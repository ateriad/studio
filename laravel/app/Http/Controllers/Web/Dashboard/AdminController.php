<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\Role;
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

class AdminController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ADMINS_INDEX)) {
            abort(403);
        }

        return view('pages.dashboard.admins.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request): JsonResponse
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ADMINS_INDEX)) {
            abort(403);
        }

        $admins = User::has('roles');

        $total = $admins->count();
        $admins = $admins->offset($request->get('start'))->limit($request->get('length'))->get();

        $data = new Collection();
        foreach ($admins as $admin) {
            /** @var User $admin */

            $obj = new stdClass();
            $obj->id = $admin->id;
            $obj->full_name = $admin->full_name;
            $obj->cellphone = $admin->cellphone;
            $obj->roles = $admin->roles()->pluck('title');

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
     * @param User $admin
     * @return Factory|View
     */
    public function edit(User $admin)
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ADMINS_UPDATE)) {
            abort(403);
        }

        $roles = Role::all();

        return view('pages.dashboard.admins.edit', [
            'admin' => $admin,
            'roles' => $roles,
        ]);
    }

    /**
     * @param Request $request
     * @param User $admin
     * @return RedirectResponse
     */
    public function update(Request $request, User $admin): RedirectResponse
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ADMINS_UPDATE)) {
            abort(403);
        }

        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['nullable', 'email', 'unique:users,email,' . $admin->id],
            'cellphone' => ['required', 'cellphone', 'unique:users,cellphone,' . $admin->id],
            'image' => 'nullable|mimes:jpeg,png,gif,svg|max:1024',
        ]);

        $admin->first_name = $request->get('first_name');
        $admin->last_name = $request->get('last_name');
        $admin->cellphone = $request->get('cellphone');
        $admin->cellphone_verified_at = null;

        if ($admin->email != $request->get('email')) {
            $email = UserEmailReset::updateOrCreate([
                'user_id' => auth()->id()
            ], [
                'email' => $request->input('email'),
                'token' => Random::alphabetic(32),
            ]);

            Mail::to($email->email)->send(new EmailVerification($admin, $email->token));
        }

        if ($request->file('image') != null) {
            $admin->image = $request->file('image')->store('avatars/' . $user->id, 'public');
        }

        $admin->save();

        return redirect()->route('dashboard.admins.index')->with('success', trans('admins.updated'));
    }

    /**
     * @param User $admin
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(User $admin): JsonResponse
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ADMINS_DELETE)) {
            abort(403);
        }

        if ($admin->hasRole(1)) {
            return new JsonResponse(['message' => 'can not delete'], 403);
        }

        $admin->delete();

        return new JsonResponse(['message' => trans('admins.deleted')]);
    }
}
