<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\SignInActivityTypes;
use App\Http\Controllers\Controller;
use App\Models\SignInActivity;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class SignInController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('pages.auth.sign_in');
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function request(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'cellphone'],
            'password' => 'required',
        ]);

        $credential = [
            'cellphone' => $request->get('cellphone'),
            'password' => trim($request->get('password')),
        ];

        $signInActivity = new SignInActivity();
        $signInActivity->ip = $request->getClientIp() ?? 'N/A';
        $signInActivity->agent = $request->userAgent() ?? 'N/A';

        if (Auth::attempt($credential, $request->get('remember_me'))) {
            $signInActivity->user_id = Auth::id();
            $signInActivity->type = SignInActivityTypes::SUCCESSFUL;
            $signInActivity->save();

            return redirect()->route('dashboard.index');
        }

        if ($user = User::whereCellphone($credential['cellphone'])->first()) {
            $signInActivity->user_id = $user->id ?? 0;
            $signInActivity->type = SignInActivityTypes::FAILED;
            $signInActivity->save();
        }

        return redirect()->back()->with('error', trans('auth.failed'));
    }
}
