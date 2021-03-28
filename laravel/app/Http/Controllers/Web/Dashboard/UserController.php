<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Models\User;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
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
