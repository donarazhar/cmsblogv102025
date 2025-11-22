<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class GalleryAlbum extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'cover_image',
        'event_date',
        'location',
        'order',
        'is_active',
    ];

    protected $casts = [
        'event_date' => 'date',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Boot method untuk auto-generate slug
     */
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($album) {
            if (empty($album->slug)) {
                $album->slug = Str::slug($album->name);

                // Check if slug exists, add number if duplicate
                $count = static::where('slug', 'LIKE', $album->slug . '%')->count();
                if ($count > 0) {
                    $album->slug = $album->slug . '-' . ($count + 1);
                }
            }
        });

        static::updating(function ($album) {
            if ($album->isDirty('name') && empty($album->slug)) {
                $album->slug = Str::slug($album->name);

                // Check if slug exists, add number if duplicate
                $count = static::where('slug', 'LIKE', $album->slug . '%')
                    ->where('id', '!=', $album->id)
                    ->count();
                if ($count > 0) {
                    $album->slug = $album->slug . '-' . ($count + 1);
                }
            }
        });
    }

    /**
     * Relationships
     */
    public function galleries()
    {
        return $this->hasMany(Gallery::class, 'album_id');
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')
            ->orderBy('event_date', 'desc')
            ->orderBy('created_at', 'desc');
    }

    /**
     * Accessors
     */
    public function getPhotosCountAttribute()
    {
        return $this->galleries()->count();
    }
}
