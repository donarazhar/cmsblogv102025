<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Page extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'featured_image',
        'template',
        'status',
        'show_in_menu',
        'menu_order',
        'parent_id',
        'icon',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'custom_fields',
    ];

    protected $casts = [
        'show_in_menu' => 'boolean',
        'menu_order' => 'integer',
        'custom_fields' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url'];

    // Relationships
    public function parent(): BelongsTo
    {
        return $this->belongsTo(Page::class, 'parent_id');
    }

    public function children(): HasMany
    {
        return $this->hasMany(Page::class, 'parent_id');
    }

    // Scopes
    public function scopePublished($query)
    {
        return $query->where('status', 'published');
    }

    public function scopeInMenu($query)
    {
        return $query->where('show_in_menu', true)
            ->orderBy('menu_order', 'asc');
    }

    public function scopeParent($query)
    {
        return $query->whereNull('parent_id');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('pages.show', $this->slug);
    }

    // Mutators
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }
}
