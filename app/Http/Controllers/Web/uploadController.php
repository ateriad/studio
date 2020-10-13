<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class uploadController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $request->validate([
            'file' => ['required', 'file', 'mimetypes:image/*,video/*,audio/*,application/octet-stream', 'max:99999',],
        ]);

        $path = $request->file('file')->storeAs(
            'temp/' . date('Y-m-d'),
            time() . Str::random(30) . '.' . $request->file('file')->getClientOriginalExtension()
        );

        return new JsonResponse([
            'path' => $path,
        ]);
    }
}
