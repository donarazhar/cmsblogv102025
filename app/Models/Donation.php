<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Donation extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'campaign_name',
        'slug',
        'description',
        'content',
        'image',
        'category',
        'target_amount',
        'current_amount',
        'donor_count',
        'start_date',
        'end_date',
        'is_urgent',
        'is_featured',
        'is_active',
        'order',
        'payment_methods',
    ];

    protected $casts = [
        'is_urgent' => 'boolean',
        'is_featured' => 'boolean',
        'is_active' => 'boolean',
        'order' => 'integer',
        'target_amount' => 'decimal:2',
        'current_amount' => 'decimal:2',
        'donor_count' => 'integer',
        'payment_methods' => 'array',
        'start_date' => 'date',
        'end_date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url', 'percentage', 'days_left'];

    // Relationships
    public function transactions(): HasMany
    {
        return $this->hasMany(DonationTransaction::class);
    }

    public function verifiedTransactions(): HasMany
    {
        return $this->hasMany(DonationTransaction::class)->where('status', 'verified');
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

    public function scopeUrgent($query)
    {
        return $query->where('is_urgent', true);
    }

    public function scopeOngoing($query)
    {
        return $query->where(function ($q) {
            $q->whereNull('end_date')
                ->orWhere('end_date', '>=', now()->toDateString());
        });
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return route('donations.show', $this->slug);
    }

    public function getPercentageAttribute(): float
    {
        if (!$this->target_amount || $this->target_amount == 0) {
            return 0;
        }
        return min(100, ($this->current_amount / $this->target_amount) * 100);
    }

    public function getDaysLeftAttribute(): ?int
    {
        if (!$this->end_date) {
            return null;
        }
        $days = now()->diffInDays($this->end_date, false);
        return $days > 0 ? $days : 0;
    }

    // Mutators
    public function setCampaignNameAttribute($value)
    {
        $this->attributes['campaign_name'] = $value;
        $this->attributes['slug'] = $this->attributes['slug'] ?? Str::slug($value);
    }

    // Methods
    public function updateAmount(float $amount)
    {
        $this->increment('current_amount', $amount);
        $this->increment('donor_count');
    }
}
