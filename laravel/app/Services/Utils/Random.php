<?php

namespace App\Services\Utils;

use Exception;
use Illuminate\Support\Str;

class Random
{
    /**
     * Generate numeric random number
     *
     * @param int $min
     * @param int $max
     * @return int
     */
    public static function numeric(int $min, int $max): int
    {
        try {
            return random_int($min, $max);
        } catch (Exception $e) {
            return mt_rand($min, $max);
        }
    }

    /**
     * Generate random string
     * @param int $length
     * @return string
     */
    public static function alphabetic(int $length = 32): string
    {
        try {
            return bin2hex(random_bytes($length));
        } catch (Exception $e) {
            return Str::random($length);
        }
    }
}
