<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
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
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
        'event_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url', 'photos_count'];

    // Relationships
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class, 'album_id');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('event_date', 'desc');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('gallery.album', $this->slug);
    }

    public function getPhotosCountAttribute(): int
    {
        return $this->galleries()->where('is_active', true)->count();
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }
}
