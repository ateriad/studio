<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Enums\Permissions;
use App\Http\Controllers\Controller;
use App\Models\Stream;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use stdClass;

class StreamController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $streams = Stream::whereUserId(Auth::id())->orderByDesc('id')->get();

        return view('pages.dashboard.streams.index', [
            'streams' => $streams,
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function datatable(Request $request)
    {
        $user = Auth::user();

        if ($user->isAdmin()) {
            $streams = Stream::where('id', '<>', null);
        } else {
            $streams = Stream::where('user_id', $user->id);
        }

        switch ($request->input('columns')[$request->input('order.0.column')]['name']) {
            case 'id':
                $streams->orderBy('id', $request->input('order.0.dir'));
                break;
        }

        $total = $streams->count();
        $streams = $streams->offset($request->get('start'))->limit($request->get('length'))->get();

        $data = new Collection();
        foreach ($streams as $stream) {
            /** @var Stream $category */

            $obj = new stdClass();
            $obj->id = $stream->id;
            if ($user->isAdmin()) {
                $obj->user_name = $stream->user->full_name;
            }
            $obj->thumbnail = $stream->thumb;
            $obj->path = public_storage_path($stream->file);
            $obj->updated_at = jDate($stream->updated_at);
            $obj->created_at = jDate($stream->created_at);

            $obj->delete_url = route('dashboard.streams.destroy', ['stream' => $stream->id]);

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
     * @param Stream $stream
     * @return JsonResponse
     * @throws Exception
     */
    public function destroy(Stream $stream)
    {
        $user = Auth::user();
        if ($stream->user_id != $user->id or $user->cannot(Permissions::STREAMS_DELETE)) {
            abort(403);
        }

        $stream->delete();

        if (Storage::exists($stream->file)) {
            Storage::delete($stream->file);
        }

        return new JsonResponse(['message' => trans('streams.deleted')]);
    }
}
