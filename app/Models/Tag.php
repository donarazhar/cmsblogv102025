<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Support\Str;

class Tag extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url', 'posts_count'];

    // Relationships
    public function posts(): BelongsToMany
    {
        return $this->belongsToMany(Post::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePopular($query, $limit = 10)
    {
        return $query->withCount('posts')
            ->orderBy('posts_count', 'desc')
            ->limit($limit);
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('tags.show', $this->slug);
    }

    public function getPostsCountAttribute(): int
    {
        return $this->posts()->where('status', 'published')->count();
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }
}
