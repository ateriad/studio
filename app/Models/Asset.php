<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * App\Models\Asset
 *
 * @property int $id
 * @property string $name
 * @property string $thumbnail
 * @property string $type
 * @property string $path
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Models\AssetCategory[] $categories
 * @property-read int|null $categories_count
 * @property-read string $thumbnail_url
 * @method static \Illuminate\Database\Eloquent\Builder|Asset newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asset newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|Asset query()
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset wherePath($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereThumbnail($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|Asset whereUpdatedAt($value)
 * @mixin \Eloquent
 * @property-read string $path_url
 */
class Asset extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public $appends = [
        'thumbnail_url',
        'path_url',
    ];

    /**
     * @return string
     */
    public function getThumbnailUrlAttribute()
    {
        return isset($this->thumbnail) ? public_storage_path($this->thumbnail) : '';
    }

    /**
     * @return string
     */
    public function getPathUrlAttribute()
    {
        return isset($this->path) ? public_storage_path($this->path) : '';
    }

    /**
     * @return BelongsToMany
     */
    public function categories()
    {
        return $this->belongsToMany(AssetCategory::class, 'asset_category', 'asset_id', 'category_id');
    }
}
