<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class uploadController
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function upload(Request $request)
    {
        $path = $request->file('file')->store('temp/' . date('Y-m-d'));

        return new JsonResponse([
            'path' => $path,
        ]);
    }
}
