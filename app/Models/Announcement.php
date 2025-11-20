<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Announcement extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'content',
        'type',
        'priority',
        'icon',
        'link',
        'link_text',
        'start_date',
        'end_date',
        'show_on_homepage',
        'show_popup',
        'is_active',
        'order',
        'created_by',
    ];

    protected $casts = [
        'show_on_homepage' => 'boolean',
        'show_popup' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('end_date')
                    ->orWhere('end_date', '>=', now());
            });
    }

    public function scopeOnHomepage($query)
    {
        return $query->where('show_on_homepage', true);
    }

    public function scopePopup($query)
    {
        return $query->where('show_popup', true);
    }

    public function scopeByPriority($query)
    {
        $priorityOrder = ['urgent' => 1, 'high' => 2, 'medium' => 3, 'low' => 4];
        return $query->orderByRaw("FIELD(priority, 'urgent', 'high', 'medium', 'low')");
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accessors
    public function getIsCurrentlyActiveAttribute(): bool
    {
        if (!$this->is_active) {
            return false;
        }

        $now = now();

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }

    public function getTypeColorAttribute(): string
    {
        return match ($this->type) {
            'success' => '#10b981',
            'warning' => '#f59e0b',
            'danger' => '#ef4444',
            default => '#0053C5',
        };
    }
}
