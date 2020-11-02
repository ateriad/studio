<?php

namespace App\Http\Controllers\Web\Account;

use App\Http\Controllers\Controller;
use App\Models\UserEmailReset;
use Exception;
use Illuminate\Http\RedirectResponse;

class EmailResetController extends Controller
{
    /**
     * @param string $token
     * @return RedirectResponse
     * @throws Exception
     */
    public function verify(string $token)
    {
        $emailReset = UserEmailReset::whereToken($token)->firstOrFail();

        $emailReset->user->update(['email' => $emailReset->email, 'email_verified_at' => now()]);
        $emailReset->delete();

        return redirect()->route('home')->with('success', trans('profile.email_verified'));
    }
}
