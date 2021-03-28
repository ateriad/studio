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

        //

        return view('pages.dashboard.admins.edit', [
            'admin' => $admin,
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
            'name' => ['required', 'unique:users,name,' . $admin->id],
        ]);

        //

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
