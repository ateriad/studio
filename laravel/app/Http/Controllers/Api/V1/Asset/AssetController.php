<?php

namespace App\Http\Controllers\Api\V1\Asset;

use App\Http\Controllers\Controller;
use App\Models\Asset;
use App\Models\AssetCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function index(Request $request)
    {
        $request->validate([
            'per_page' => ['nullable', 'numeric', 'min:1', 'max:100'],
        ]);

        $type = $request->get('type');

        if (empty($type)) {
            return new JsonResponse(
                Asset::with(['categories'])
                    ->orderByDesc('id')
                    ->paginate($request->input('per_page', 10))
            );
        }

        return new JsonResponse(
            Asset::with(['categories'])
                ->where('type', $type)
                ->orderByDesc('id')
                ->paginate($request->input('per_page', 10))
        );
    }
}
