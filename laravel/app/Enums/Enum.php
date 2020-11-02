<?php

namespace App\Enums;

use Illuminate\Support\Str;
use MiladRahimi\Enum\Enum as MiladEnum;
use ReflectionClass;
use ReflectionException;

abstract class Enum extends MiladEnum
{
    /**
     * @return array
     */
    public static function all(): array
    {
        try {
            return (new ReflectionClass(static::class))->getConstants();
        } catch (ReflectionException $e) {
            return [];
        }
    }

    public static function translatedAll()
    {
        $namespace = str_replace('App\\', '', get_called_class());

        $arr = [];
        foreach (explode('\\', $namespace) as $n) {
            $arr[] = Str::snake($n);
        }

        $preFix = implode('/', $arr);

        $all = static::all();
        foreach ($all as $key => $value) {
            $transKey = $preFix . '.' . $key;
            $all[trans($transKey)] = $all[$key];
            unset($all[$key]);
        }

        return $all;
    }

    public static function translatedKeyOf($value, $default = null)
    {
        $namespace = str_replace('App\\', '', get_called_class());

        $arr = [];
        foreach (explode('\\', $namespace) as $n) {
            $arr[] = Str::snake($n);
        }

        $preFix = implode('/', $arr);

        if (is_array($value)) {
            $keys = [];
            foreach ($value as $val) {
                $keys[] = static::keyOf($val) ? trans($preFix . '.' . static::keyOf($val)) : $default;
            }
            return $keys;
        }

        return static::keyOf($value) ? trans($preFix . '.' . static::keyOf($value)) : $default;
    }
}
