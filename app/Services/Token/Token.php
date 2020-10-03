<?php

namespace App\Services\Token;

interface Token
{
    /**
     * Generate token from user
     *
     * @param int $userId
     * @return string
     */
    public function generate(int $userId): string;

    /**
     * Extract user id form token
     *
     * @param string $jwt
     * @return int|null
     */
    public function extract(string $jwt): ?int;
}
