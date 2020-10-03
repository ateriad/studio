<?php

namespace App\Rules;

use App\Services\Otp\Otp;
use Illuminate\Contracts\Validation\Rule;

class OtpCheck implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param string $attribute
     * @param mixed $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        /** @var Otp $otp */
        $otp = app(Otp::class);

        return $otp->check(request()->input('cellphone'), $value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return trans('validation.exists', ['attribute' => trans('validation.attributes.otp')]);
    }
}
