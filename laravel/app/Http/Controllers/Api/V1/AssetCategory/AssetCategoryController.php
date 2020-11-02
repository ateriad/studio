<?php

namespace App\Http\Controllers\Api\V1\AssetCategory;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AssetCategoryController extends Controller
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

        return new JsonResponse(
            AssetCategory::with(['assets'])
                ->where('parent_id', '<>' , 0)
                ->orderByDesc('id')
                ->paginate($request->input('per_page', 10))
        );
    }
}
