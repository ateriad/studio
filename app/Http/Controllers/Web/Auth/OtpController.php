<?php

namespace App\Http\Controllers\Web\Auth;

use App\Enums\SignInActivityTypes;
use App\Http\Controllers\Controller;
use App\Jobs\Users\SendSms;
use App\Models\SignInActivity;
use App\Models\User;
use App\Rules\OtpCheck;
use App\Services\Otp\Otp;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class OtpController extends Controller
{
    /**
     * @return Application|Factory|View
     */
    public function show()
    {
        return view('pages.auth.otp');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws ValidationException
     */
    public function request(Request $request)
    {
        $this->validate($request, [
            'cellphone' => ['required', 'cellphone'],
        ]);

        $cellphone = $request->input('cellphone');

        /** @var Otp $otp */
        $otp = app(Otp::class);
        $code = $otp->store($cellphone);

        if (app()->environment('local')) {
            return new JsonResponse([
                'message' => $code,
                'expires_after' => config('otp.targets.sms.ttl'),
            ]);
        }

        SendSms::dispatch($cellphone, trans('auth.otp-sms', ['otp' => $code]));

        return new JsonResponse([
            'message' => trans('auth.code_sent'),
            'expires_after' => config('otp.targets.sms.ttl'),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     * @throws ValidationException
     */
    public function submit(Request $request)
    {
        $this->validate($request, [
            'cellphone' => ['required', 'cellphone'],
            'code' => ['required', 'numeric', 'digits:6', new OtpCheck()],
        ]);

        $cellphone = $request->input('cellphone');

        $user = User::withTrashed()->whereCellphone($cellphone)->first();

        if (empty($user)) {
            $user = new User();
            $user->cellphone = $cellphone;
            $user->cellphone_verified_at = Carbon::now();
            $user->save();
        }

        if ($user->trashed()) {
            throw new Exception('this user is deleted, you cant use this cellphone');
        }

        auth()->loginUsingId($user->id, true);

        $signInActivity = new SignInActivity();
        $signInActivity->ip = $request->getClientIp() ?? 'N/A';
        $signInActivity->agent = $request->userAgent() ?? 'N/A';
        $signInActivity->user_id = $user->id;
        $signInActivity->type = SignInActivityTypes::SUCCESSFUL;
        $signInActivity->save();

        return new JsonResponse([
            'redirect' => route('dashboard.index'),
        ]);
    }
}
