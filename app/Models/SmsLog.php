<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;


/**
 * App\Models\SmsLog
 *
 * @property int $id
 * @property string $sms_id
 * @property string $number
 * @property string $body
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog query()
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereBody($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereNumber($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereSmsId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|SmsLog whereUpdatedAt($value)
 * @mixin \Eloquent
 */
class SmsLog extends Model
{
    use HasFactory;
}
