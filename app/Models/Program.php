<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

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
        'location',
        'start_date',
        'end_date',
        'start_time',
        'end_time',
        'registration_fee',
        'max_participants',
        'current_participants',
        'organizer',
        'speaker',
        'contact_person',
        'contact_phone',
        'order',
        'is_active',
        'is_featured',
        'is_registration_open',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'registration_fee' => 'decimal:2',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'is_registration_open' => 'boolean',
    ];

    /**
     * Relationships
     */
    public function registrations()
    {
        return $this->hasMany(ProgramRegistration::class);
    }

    /**
     * Scopes
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeUpcoming($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('start_date')
              ->orWhere('start_date', '>=', now());
        });
    }

    public function scopeOngoing($query)
    {
        return $query->where(function ($q) {
            $q->where(function ($subQ) {
                $subQ->whereNotNull('start_date')
                     ->whereNotNull('end_date')
                     ->where('start_date', '<=', now())
                     ->where('end_date', '>=', now());
            })->orWhere(function ($subQ) {
                $subQ->whereNotNull('start_date')
                     ->whereNull('end_date')
                     ->where('start_date', '<=', now());
            });
        });
    }

    /**
     * Accessors
     */
    public function getIsFreeAttribute()
    {
        return $this->registration_fee == 0;
    }

    public function getIsFullAttribute()
    {
        if (!$this->max_participants) {
            return false;
        }
        return $this->current_participants >= $this->max_participants;
    }

    public function getAvailableSlotsAttribute()
    {
        if (!$this->max_participants) {
            return null;
        }
        return max(0, $this->max_participants - $this->current_participants);
    }

    public function getDaysLeftAttribute()
    {
        if (!$this->end_date) {
            return null;
        }
        $now = Carbon::now();
        $endDate = Carbon::parse($this->end_date);
        
        if ($endDate->isPast()) {
            return 0;
        }
        
        return $now->diffInDays($endDate);
    }

    public function getStatusAttribute()
    {
        if (!$this->start_date) {
            return 'ongoing';
        }

        $now = Carbon::now();
        $startDate = Carbon::parse($this->start_date);
        
        if ($this->end_date) {
            $endDate = Carbon::parse($this->end_date);
            
            if ($now->isBefore($startDate)) {
                return 'upcoming';
            } elseif ($now->isAfter($endDate)) {
                return 'completed';
            } else {
                return 'ongoing';
            }
        }
        
        return $now->isBefore($startDate) ? 'upcoming' : 'ongoing';
    }
}