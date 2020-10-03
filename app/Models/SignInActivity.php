<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * App\Models\SignInActivity
 *
 * @property int $id
 * @property int $user_id
 * @property int $type
 * @property string $ip
 * @property string $agent
 * @property \Illuminate\Support\Carbon $created_at
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity query()
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity whereAgent($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity whereIp($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SignInActivity whereUserId($value)
 * @mixin \Eloquent
 */
class SignInActivity extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

}
