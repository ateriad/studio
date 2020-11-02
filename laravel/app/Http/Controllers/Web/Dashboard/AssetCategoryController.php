<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Exception;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;

class AssetCategoryController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ASSET_CATEGORIES_INDEX)) {
            abort(403);
        }

        return view('pages.dashboard.asset_categories.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request)
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ASSET_CATEGORIES_INDEX)) {
            abort(403);
        }

        $categories = AssetCategory::withCount('assets');

        foreach ($request->input('columns') as $column) {
            if ($column['search']['value'] != "") {
                $val = $column['search']['value'];
                switch ($column['name']) {
                    case 'id':
                        $categories->where('id', $val);
                        break;
                }
            }
        }

        switch ($request->input('columns')[$request->input('order.0.column')]['name']) {
            case 'id':
                $categories->orderBy('id', $request->input('order.0.dir'));
                break;
            case 'name':
                $categories->orderBy('name', $request->input('order.0.dir'));
                break;
            case 'assets_count':
                $categories->orderBy('assets_count', $request->input('order.0.dir'));
                break;
        }

        $total = $categories->count();
        $categories = $categories->offset($request->get('start'))->limit($request->get('length'))->get();

        $data = new Collection();
        foreach ($categories as $category) {
            /** @var AssetCategory $category */

            $obj = new stdClass();
            $obj->id = $category->id;
            $obj->image_url = $category->image_url;
            $obj->name = $category->name;
            $obj->parent = $category->parent->name ?? '-';
            $obj->assets_count = $category->parent != null ? $category->assets_count : '-';
            $obj->updated_at = jDate($category->updated_at);

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
        if ($user->cannot(Permissions::ASSET_CATEGORIES_CREATE)) {
            abort(403);
        }

        $parents = AssetCategory::where('parent_id', 0)->get();

        return view('pages.dashboard.asset_categories.create', [
            'parents' => $parents,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ASSET_CATEGORIES_CREATE)) {
            abort(403);
        }

        $request->validate([
            'name' => ['required'],
            'parent' => ['nullable', 'exists:asset_categories,id'],
            'image' => 'nullable|string',
            'info' => 'nullable|max:1024',
        ]);

        $category = new AssetCategory();
        $category->name = $request->get('name');
        $category->parent_id = $request->get('parent') ?? 0;
        $category->info = $request->get('info');
        $category->save();

        $image = $request->get('image');
        if (isset($image)) {
            $newPath = 'asset_categories/' . $category->id . substr($image, 15);

            Storage::move($image, $newPath);

            $category->image = $newPath;
            $category->save();
        }

        return redirect()->route('dashboard.asset-categories.index')->with('success', trans('asset_categories.created'));
    }

    /**
     * @param AssetCategory $category
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(AssetCategory $category)
    {
        $user = Auth::user();
        if ($user->cannot(Permissions::ASSET_CATEGORIES_DELETE)) {
            abort(403);
        }

        $category->assets()->detach();
        $category->delete();

        return new JsonResponse(['message' => trans('asset_categories.deleted')]);
    }
}
