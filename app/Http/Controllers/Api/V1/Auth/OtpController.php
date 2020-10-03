<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Enums\SignInActivityTypes;
use App\Http\Controllers\Controller;
use App\Jobs\Users\SendSms;
use App\Models\SignInActivity;
use App\Models\User;
use App\Rules\OtpCheck;
use App\Services\Otp\Otp;
use App\Services\Token\Token;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OtpController extends Controller
{
    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function request(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'cellphone'],
        ]);

        $cellphone = $request->input('cellphone');

        /** @var Otp $otp */
        $otp = app(Otp::class);
        $code = $otp->store($cellphone);

        $this->dispatch(new SendSms($cellphone, trans('auth.otp-sms', ['otp' => $code])));

        return new JsonResponse([
            'message' => trans('auth.code_sent'),
            'expires_after' => config('otp.targets.sms.ttl'),
        ]);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @throws Exception
     */
    public function submit(Request $request)
    {
        $request->validate([
            'cellphone' => ['required', 'cellphone'],
            'otp' => ['required', 'numeric', 'digits:6', new OtpCheck()],
        ]);

        $cellphone = $request->input('cellphone');

        $user = User::withTrashed()->whereCellphone($cellphone)->first();
        if (empty($user)) {
            $user = new User();
            $user->cellphone = $cellphone;
            $user->cellphone_verified_at = now();
            $user->save();
        }

        if ($user->trashed()) {
            throw new Exception('this user is deleted, you can not use this cellphone');
        }

        $signInActivity = new SignInActivity();
        $signInActivity->ip = $request->getClientIp() ?? 'N/A';
        $signInActivity->agent = $request->userAgent() ?? 'N/A';
        $signInActivity->user_id = $user->id;
        $signInActivity->type = SignInActivityTypes::SUCCESSFUL;
        $signInActivity->save();

        /** @var Token $token */
        $token = app(Token::class);

        return new JsonResponse([
            'token' => $token->generate($user->id),
            'user' => $user,
        ]);
    }
}
