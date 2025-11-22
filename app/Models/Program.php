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
        'speaker',
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

    protected $appends = ['is_full', 'available_slots', 'registration_percentage'];

    // Auto-generate slug dari name
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($program) {
            if (empty($program->slug)) {
                $program->slug = Str::slug($program->name);

                // Check if slug exists, add number if duplicate
                $count = static::where('slug', 'LIKE', $program->slug . '%')->count();
                if ($count > 0) {
                    $program->slug = $program->slug . '-' . ($count + 1);
                }
            }
        });

        static::updating(function ($program) {
            if ($program->isDirty('name') && empty($program->slug)) {
                $program->slug = Str::slug($program->name);

                // Check if slug exists, add number if duplicate
                $count = static::where('slug', 'LIKE', $program->slug . '%')
                    ->where('id', '!=', $program->id)
                    ->count();
                if ($count > 0) {
                    $program->slug = $program->slug . '-' . ($count + 1);
                }
            }
        });
    }

    // Relationships
    public function registrations(): HasMany
    {
        return $this->hasMany(ProgramRegistration::class, 'program_id');
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

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeRegistrationOpen($query)
    {
        return $query->where('is_registration_open', true);
    }

    // Accessors
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

    public function getRegistrationPercentageAttribute(): float
    {
        if (!$this->max_participants || $this->max_participants == 0) {
            return 0;
        }
        return min(100, ($this->current_participants / $this->max_participants) * 100);
    }
}
