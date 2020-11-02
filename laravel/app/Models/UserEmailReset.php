<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * App\Models\UserEmailReset
 *
 * @property int $id
 * @property int $user_id
 * @property string $email
 * @property string $token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset query()
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset whereToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|UserEmailReset whereUserId($value)
 * @mixin \Eloquent
 */
class UserEmailReset extends Model
{
    use HasFactory;

    /**
     * @var array
     */
    protected $guarded = ['id', 'created_at', 'updated_at'];

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
