<?php

namespace App\Http\Controllers\Api\V1\Stream;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StreamController extends Controller
{

    public function create()
    {
        $user = Auth::user();
        $fileName = time() . Str::random(30);

        return new JsonResponse([
            'fileDirectory' => substr( storage_path("app/public/streams/$user->id/"),  4),
            'fileName' => "$fileName.flv",
        ]);
    }
}
