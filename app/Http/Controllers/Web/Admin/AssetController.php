<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Storage;
use stdClass;

class AssetController extends Controller
{
    /**
     * @return Factory|View
     */
    public function index()
    {
        return view('pages.admin.assets.index');
    }

    /**
     * @return Factory|View
     */
    public function create()
    {
        $categories = AssetCategory::where('parent_id', '<>', 0)->get();

        return view('pages.admin.assets.create', [
            'categories' => $categories,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request)
    {
        $assets = Asset::where('id', '<>', null);

        foreach ($request->input('columns') as $column) {
            if ($column['search']['value'] != "") {
                $val = $column['search']['value'];
                switch ($column['name']) {
                    case 'id':
                        $assets->where('id', $val);
                        break;
                }
            }
        }

        switch ($request->input('columns')[$request->input('order.0.column')]['name']) {
            case 'id':
                $assets->orderBy('id', $request->input('order.0.dir'));
                break;
        }

        $total = $assets->count();
        $assets = $assets->offset($request->get('start'))->limit($request->get('length'))->get();

        $data = new Collection();
        foreach ($assets as $asset) {
            /** @var Asset $category */

            $obj = new stdClass();
            $obj->id = $asset->id;
            $obj->name = $asset->name;
            $obj->thumbnail = public_storage_path($asset->thumbnail);
            $obj->path = public_storage_path($asset->path);
            $obj->categories = $asset->categories->toArray();
            $obj->updated_at = jDate($asset->updated_at);

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
     * @param Request $request
     * @return RedirectResponse
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'unique:assets,name',],
            'categories' => ['required', 'array',],
            'thumbnail' => ['required', 'mimes:jpeg,jpg,png,gif,svg', 'max:1024',],
            'file' => ['required', 'string',],
        ]);

        $file = $request->get('file');

        $last_id = Asset::latest('id')->first('id')->id ?? 0;
        $newPath = 'assets/files/' . ($last_id + 1) . substr($file, 15);
        Storage::move($file, $newPath);

        $asset = new Asset();
        $asset->name = $request->get('name');
        $asset->thumbnail = $request->file('thumbnail')->store('assets/thumb/' . ($last_id + 1), 'public');
        $asset->type = pathinfo($file, PATHINFO_EXTENSION);
        $asset->path = $newPath;
        $asset->save();

        $asset->categories()->attach($request->get('categories'));

        return redirect()->route('admin.assets.index')->with('success', trans('assets.created'));
    }
}
