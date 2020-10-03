<?php

namespace App\Services\Otp;

interface Otp
{
    /**
     * Store a new OTP
     *
     * @param string $id
     * @return string
     */
    public function store(string $id): string;

    /**
     * Check the given OTP
     *
     * @param string $id
     * @param string $otp
     * @return bool
     */
    public function check(string $id, string $otp): bool;
}
