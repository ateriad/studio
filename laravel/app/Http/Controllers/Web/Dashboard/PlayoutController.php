<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Models\AssetCategory;
use App\Services\Token\Token;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PlayoutController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function index()
    {
        $assetCategories = AssetCategory::has('parent')->whereHas('assets', function ($q) {
            $q->wherein('type', ['jpg', 'jpeg', 'png']);
        })->with('assets')->get();

        /** @var Token $token */
        $token = app(Token::class);
        $jwt = $token->generate(Auth::id());

        $socketServerUrl = "wss://tagta.ir/wss/stream/$jwt";
        if (app()->environment('local')) {
            $socketServerUrl = "ws://localhost:3000/stream/$jwt";
        }

        return view('pages.dashboard.playout.playout', [
            'assetCategories' => $assetCategories,
            'socketServerUrl' => $socketServerUrl,
        ]);
    }
}
