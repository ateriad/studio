<?php

namespace App\Services\Otp;

use Illuminate\Support\Facades\Redis as R;
use App\Services\Utils\Random;

class Redis implements Otp
{
    private $connection = 'default';

    /**
     * @var string
     */
    private $ttl;

    /**
     * Redis constructor.
     */
    public function __construct()
    {
        $this->ttl = config('tp.drivers.redis.ttl');
    }

    /**
     * @inheritDoc
     */
    public function store(string $id): string
    {
        $otp = Random::numeric(100000, 999999);

        R::connection($this->connection)->command('SET', ["otp:$id", $otp, $this->ttl]);

        return $otp;
    }

    /**
     * @inheritDoc
     */
    public function check(string $id, string $otp): bool
    {
        return $otp == R::connection($this->connection)->command('GET', ["otp:$id"]);
    }
}
