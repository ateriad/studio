<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

/**
 * App\Models\Stream
 *
 * @property int $id
 * @property int $user_id
 * @property string $file
 * @property string|null $info
 * @property int $status
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @method static \Illuminate\Database\Eloquent\Builder|Stream newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stream newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Stream query()
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereFile($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereInfo($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereStatus($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Stream whereUserId($value)
 * @mixin \Eloquent
 */
class Stream extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $appends = ['thumb'];

    /**
     * @param $value
     * @return string
     */
    public function getThumbAttribute()
    {
        $name = basename($this->file);
        $thumb = str_replace($name, "thumbs/$name", $this->file);
        $thumb = str_replace('.mp4', '.png', $thumb);

        if (Storage::exists($thumb)) {
            return public_storage_path($thumb);
        }

        return asset('images/test.jpg');
    }

    /**
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
