<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use stdClass;

class AssetCategoryController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('pages.admin.asset_categories.index');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request)
    {
        $categories = AssetCategory::where('id', '<>', null);

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
        }

        $total = $categories->count();
        $categories = $categories->offset($request->get('start'))->limit($request->get('length'))->get();

        $data = new Collection();
        foreach ($categories as $category) {
            /** @var AssetCategory $category */

            $obj = new stdClass();
            $obj->id = $category->id;
            $obj->name = $category->name;
            $obj->parent = $category->parent->name;
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
        $parents = AssetCategory::where('parent_id', 0)->get();

        return view('pages.admin.asset_categories.create', [
            'parents' => $parents,
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
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

        return redirect()->route('admin.asset-categories.index')->with('success', trans('asset_categories.created'));
    }
}
