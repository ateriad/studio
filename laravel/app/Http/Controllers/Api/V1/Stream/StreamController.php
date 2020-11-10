<?php

namespace App\Http\Controllers\Api\V1\Stream;

use App\Enums\StreamStatus;
use App\Http\Controllers\Controller;
use App\Models\Stream;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class StreamController extends Controller
{
    /**
     * this method used by node server
     *
     * @return JsonResponse
     */
    public function start()
    {
        $user = Auth::user();
        $lastId = Stream::select('id')->latest()->first()->id ?? 0;
        $id = $lastId + 1;

        $stream = Stream::create([
            'user_id' => $user->id,
            'file' => "streams/$user->id/$id/" . time() . Str::random(25) . ".mp4",
            'status' => StreamStatus::Start,
        ]);

        return new JsonResponse($stream);
    }

    /**
     * @param Stream $stream
     * @return JsonResponse
     */
    public function finish(Stream $stream)
    {
        $stream->update([
            'status' => StreamStatus::Successful,
        ]);

        return new JsonResponse($stream);
    }
}
