<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class StudioController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $assetCategories = AssetCategory::whereHas('parent')->has('assets')->get();

        return view('pages.dashboard.studio', [
            'assetCategories' => $assetCategories,
        ]);
    }
}
