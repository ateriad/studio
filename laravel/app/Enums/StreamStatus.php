<?php

namespace App\Enums;

class StreamStatus extends Enum
{
    const Start = 1;
    const Streaming = 2;
    const Successful = 3;
    const Failed = 4;
}
