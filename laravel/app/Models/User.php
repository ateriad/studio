<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * App\Models\User
 *
 * @property int $id
 * @property string|null $first_name
 * @property string|null $last_name
 * @property string|null $email
 * @property \Illuminate\Support\Carbon|null $email_verified_at
 * @property string $cellphone
 * @property \Illuminate\Support\Carbon|null $cellphone_verified_at
 * @property string|null $banned_until
 * @property string|null $image
 * @property string|null $password
 * @property string|null $remember_token
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read string $full_name
 * @property-read \Illuminate\Notifications\DatabaseNotificationCollection|\Illuminate\Notifications\DatabaseNotification[] $notifications
 * @property-read int|null $notifications_count
 * @method static \Illuminate\Database\Eloquent\Builder|User newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|User newQuery()
 * @method static \Illuminate\Database\Query\Builder|User onlyTrashed()
 * @method static \Illuminate\Database\Eloquent\Builder|User query()
 * @method static \Illuminate\Database\Eloquent\Builder|User whereBannedUntil($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCellphone($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCellphoneVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereDeletedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereEmailVerifiedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereFirstName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereImage($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereLastName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User wherePassword($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereRememberToken($value)
 * @method static \Illuminate\Database\Eloquent\Builder|User whereUpdatedAt($value)
 * @method static \Illuminate\Database\Query\Builder|User withTrashed()
 * @method static \Illuminate\Database\Query\Builder|User withoutTrashed()
 * @mixin \Eloquent
 * @property-read \App\Models\UserEmailReset|null $userEmailReset
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\Role[] $roles
 * @property-read int|null $roles_count
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $hidden = [
        'password',
        'email_verified_at',
        'cellphone_verified_at',
        'updated_at',
        'deleted_at',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'cellphone_verified_at' => 'datetime',
    ];

    public $appends = ['full_name'];

    /**
     * @return string
     */
    public function getFullNameAttribute(): string
    {
        return isset($this->first_name) ? $this->first_name . ' ' . $this->last_name : $this->cellphone;
    }

    /**
     * @param $value
     * @return string
     */
    public function getImageAttribute($value): string
    {
        return isset($value) ? public_storage_path($value) : asset('dashboard_assets/images/user.jpg');
    }

    /**
     * @return BelongsToMany
     */
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class);
    }

    /**
     * @param int $roleId
     * @return bool
     */
    public function hasRole(int $roleId): bool
    {
        foreach ($this->roles as $role) {
            if ($role->id == $roleId) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param string $permissions
     * @return bool
     */
    public function hasPermission(string $permissions): bool
    {
        $permissions = explode('|', $permissions);

        foreach ($this->roles as $role) {
            foreach ($role->permissions() as $p) {
                if (in_array($p, $permissions)) {
                    return true;
                }
            }
        }

        return false;
    }

    public function isAdmin(): bool
    {
        return $this->roles()->count() > 0;
    }

    public function isSuperAdmin(): bool
    {
        $this->load('roles');

        return $this->roles()->where('title', 'super_admin')->exists();
    }

    /**
     * @return HasOne
     */
    public function userEmailReset(): HasOne
    {
        return $this->hasOne(UserEmailReset::class);
    }
}
