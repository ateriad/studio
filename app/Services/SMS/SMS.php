<?php

namespace App\Services\SMS;

interface SMS
{
    /**
     * send SMS to single phone
     *
     * @param string $phone
     * @param string $body
     */
    public function send(string $phone, string $body);

    /**
     * get array of received SMS from users
     * @return array
     */
    public function receivedSMS(): array;

    /**
     * get SMS provider balance
     * @return int
     */
    public function balance(): int;
}
