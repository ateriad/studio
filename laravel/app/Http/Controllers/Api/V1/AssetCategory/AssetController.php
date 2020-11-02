<?php

namespace App\Http\Controllers\Api\V1\AssetCategory;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetController extends Controller
{
    /**
     * @param AssetCategory $category
     * @param Request $request
     * @return JsonResponse
     */
    public function index(AssetCategory $category, Request $request)
    {
        $request->validate([
            'per_page' => ['nullable', 'numeric', 'min:1', 'max:100'],
            'type' => ['nullable', 'string', 'max:40'],
        ]);

        $type = $request->get('type');

        if (empty($type)) {
            return new JsonResponse(
                $category->assets()
                    ->orderByDesc('id')
                    ->paginate($request->input('per_page', 10))
            );
        }

        return new JsonResponse(
            $category->assets()
                ->where('type', $type)
                ->orderByDesc('id')
                ->paginate($request->input('per_page', 10))
        );
    }
}
