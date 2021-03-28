<?php

namespace App\Http\Controllers\Web\Dashboard;

use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\UserEmailReset;
use App\Services\Utils\Random;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ProfileController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function edit()
    {
        return view('pages.dashboard.profile.edit', [
            'user' => Auth::user(),
        ]);
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'first_name' => ['required', 'string'],
            'last_name' => ['nullable', 'string'],
            'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        ]);

        $user->first_name = $request->get('first_name');
        $user->last_name = $request->get('last_name');

        if ($user->email != $request->get('email')) {
            $email = UserEmailReset::updateOrCreate([
                'user_id' => auth()->id()
            ], [
                'email' => $request->input('email'),
                'token' => Random::alphabetic(32),
            ]);

            Mail::to($email->email)->send(new EmailVerification($user, $email->token));
        }

        $user->save();

        return back()->with('success', trans('profile.updated'));
    }

    /**
     * @param Request $request
     * @return RedirectResponse
     */
    public function updateImage(Request $request): RedirectResponse
    {
        $request->validate([
            'image' => 'required|mimes:jpeg,png,gif,svg|max:1024',
        ]);

        $user = Auth::user();
        $user->image = $request->file('image')->store('avatars/' . $user->id, 'public');
        $user->save();

        return back()->with('success', trans('profile.image_updated'));
    }
}
