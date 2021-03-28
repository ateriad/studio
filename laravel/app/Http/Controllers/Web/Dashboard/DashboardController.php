<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class DashboardController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $data = [];

        if(auth()->user()->isAdmin()) {
            $data['usersCount'] = User::doesntHave('roles')->count();
        }

        return view('pages.dashboard.dashboard', [
            'data' => $data,
        ]);
    }
}
