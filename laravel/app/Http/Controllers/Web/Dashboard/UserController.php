<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\User;
use App\Models\UserEmailReset;
use App\Services\Utils\Random;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use stdClass;

class UserController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::USERS_INDEX)) {
            abort(403);
        }

        return view('pages.dashboard.users.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request): JsonResponse
    {
        $admin = Auth::user();
        if ($admin->cannot(Permissions::USERS_INDEX)) {
            abort(403);
        }

        $users = User::doesntHave('roles');

        switch ($request->input('columns')[$request->input('order.0.column')]['name']) {
            case 'id':
                $users->orderBy('id', $request->input('order.0.dir'));
                break;
        }

        $total = $users->count();
        $users = $users->offset($request->get('start'))->limit($request->get('length'))->get();

        $data = new Collection();
        foreach ($users as $user) {
            /** @var User $category */

            $obj = new stdClass();
            $obj->id = $user->id;
            $obj->full_name = $user->full_name;
            $obj->email = $user->email;
            $obj->cellphone = $user->cellphone;
            $obj->image = $user->image;
            $obj->updated_at = jDate($user->updated_at);
            $operation = '';

            $obj->operation = $operation;
            $data->add($obj);
            $obj = null;
        }

        $json_data = [
            "draw" => intval($request->input('draw')),
            "recordsTotal" => intval($total),
            "recordsFiltered" => intval($total),
            "data" => $data,
        ];

        return new JsonResponse($json_data);
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::USERS_CREATE)) {
            abort(403);
        }

        return view('pages.dashboard.users.create');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request): RedirectResponse
    {
        $admin = Auth::user();
        if ($admin->cannot(Permissions::USERS_CREATE)) {
            abort(403);
        }

        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'unique:users,email'],
            'cellphone' => ['required', 'cellphone', 'unique:users,cellphone'],
            'image' => 'nullable|mimes:jpeg,png,gif,svg|max:1024',
        ]);

        $user = new User();
        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');
        $user->cellphone = $request->get('cellphone');
        $user->cellphone_verified_at = null;
        $user->save();

        if ($user->email != null) {
            $email = UserEmailReset::updateOrCreate([
                'user_id' => auth()->id()
            ], [
                'email' => $request->input('email'),
                'token' => Random::alphabetic(32),
            ]);

            Mail::to($email->email)->send(new EmailVerification($user, $email->token));
        }

        if ($request->file('image') != null) {
            $user->image = $request->file('image')->store('avatars/' . $user->id, 'public');
        }

        $user->save();

        return redirect()->route('dashboard.users.index')->with('success', trans('users.created'));
    }

    /**
     * @param User $user
     * @return Factory|View
     */
    public function edit(User $user)
    {
        $admin = Auth::user();
        if ($admin->cannot(Permissions::USERS_UPDATE)) {
            abort(403);
        }

        return view('pages.dashboard.users.edit', [
            'user' => $user,
        ]);
    }

    /**
     * @param Request $request
     * @param User $user
     * @return RedirectResponse
     */
    public function update(Request $request, User $user): RedirectResponse
    {
        $admin = Auth::user();
        if ($admin->cannot(Permissions::USERS_UPDATE)) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'unique:users,name,' . $user->id],
        ]);

        //todo

        return redirect()->route('dashboard.users.index')->with('success', trans('users.updated'));
    }

    /**
     * @param User $user
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $user): JsonResponse
    {
        $admin = Auth::user();
        if ($admin->cannot(Permissions::USERS_DELETE)) {
            abort(403);
        }

        $user->delete();

        return new JsonResponse(['message' => trans('users.deleted')]);
    }
}
