<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Program extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'content',
        'image',
        'icon',
        'type',
        'frequency',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'location',
        'organizer',
        'contact_person',
        'contact_phone',
        'max_participants',
        'current_participants',
        'registration_fee',
        'is_registration_open',
        'is_featured',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_registration_open' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'max_participants' => 'integer',
        'current_participants' => 'integer',
        'registration_fee' => 'decimal:2',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url', 'is_full', 'available_slots'];

    // Relationships
    public function galleries(): HasMany
    {
        return $this->hasMany(Gallery::class);
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeUpcoming($query)
    {
        return $query->where('start_date', '>=', now()->toDateString())
            ->orderBy('start_date', 'asc');
    }

    public function scopeOngoing($query)
    {
        return $query->where('start_date', '<=', now()->toDateString())
            ->where('end_date', '>=', now()->toDateString());
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('programs.show', $this->slug);
    }

    public function getIsFullAttribute(): bool
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->current_participants >= $this->max_participants;
    }

    public function getAvailableSlotsAttribute(): ?int
    {
        if (!$this->max_participants) {
            return null;
        }
        return max(0, $this->max_participants - $this->current_participants);
    }

    // Mutators
    public function setNameAttribute($value)
    {
        $this->attributes['name'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }

    // Methods
    public function incrementParticipants()
    {
        $this->increment('current_participants');
    }

    public function decrementParticipants()
    {
        $this->decrement('current_participants');
    }
}
