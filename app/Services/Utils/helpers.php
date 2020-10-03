<?php

use Carbon\Carbon;

/**
 * @param Carbon $datetime
 * @param string $format
 * @param false $fixNumbers
 * @return string
 */
function jDate(Carbon $datetime, string $format = 'yyyy/MM/dd - HH:mm:ss', bool $fixNumbers = false): string
{
    $formatter = new IntlDateFormatter(
        "fa_IR@calendar=persian",
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Asia/Tehran',
        IntlDateFormatter::TRADITIONAL,
        $format
    );

    $result = $formatter->format($datetime);

    return $fixNumbers ? fixNumbers($result) : $result;
}

/**
 * @param string|null $string
 * @return string
 */
function fixNumbers(?string $string): string
{
    $persian = ['۰', '۱', '۲', '۳', '۴', '۵', '۶', '۷', '۸', '۹'];
    $arabic = ['٩', '٨', '٧', '٦', '٥', '٤', '٣', '٢', '١', '٠'];
    $num = range(0, 9);

    $convertedPersianNums = str_replace($persian, $num, $string);

    return str_replace($arabic, $num, $convertedPersianNums);
}

/**
 * @param string $jDate
 * @param string $format
 * @param false $fixNumbers
 * @return string
 */
function gDate(string $jDate, string $format = 'yyyy-MM-dd HH:mm:ss', bool $fixNumbers = false): string
{
    $fmt = new IntlDateFormatter(
        'fa_IR@calendar=persian',
        IntlDateFormatter::SHORT, //date format
        IntlDateFormatter::NONE, //time format
        'Asia/Tehran',
        IntlDateFormatter::TRADITIONAL
    );
    $time = $fmt->parse($jDate);

    $formatter = IntlDateFormatter::create("en_US@calendar=GREGORIAN",
        IntlDateFormatter::FULL,
        IntlDateFormatter::FULL,
        'Asia/Tehran',
        IntlDateFormatter::TRADITIONAL,
        $format
    );
    $result = $formatter->format($time);

    return $fixNumbers ? fixNumbers($result) : $result;
}


/**
 * Append md5 hash to the given asset
 *
 * @param string $url
 * @return string
 */
function m(string $url): string
{
    return $url . '?md5=' . md5_file(public_path(parse_url($url)['path']));
}

/**
 * @param string|null $string
 * @return string|string[]|null
 */
function parseNumber(?string $string): string
{
    return preg_replace('/[^0-9]/', '', fixNumbers($string));
}
