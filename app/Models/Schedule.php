<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Schedule extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'type',
        'date',
        'day_of_week',
        'start_time',
        'end_time',
        'location',
        'imam',
        'speaker',
        'frequency',
        'is_recurring',
        'color',
        'is_active',
    ];

    protected $casts = [
        'is_recurring' => 'boolean',
        'is_active' => 'boolean',
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopePrayer($query)
    {
        return $query->where('type', 'prayer');
    }

    public function scopeEvent($query)
    {
        return $query->where('type', 'event');
    }

    public function scopeToday($query)
    {
        return $query->where('date', now()->toDateString())
            ->orWhere(function ($q) {
                $q->where('is_recurring', true)
                    ->where('day_of_week', strtolower(now()->format('l')));
            });
    }

    public function scopeUpcoming($query, $days = 7)
    {
        return $query->where('date', '>=', now()->toDateString())
            ->where('date', '<=', now()->addDays($days)->toDateString())
            ->orderBy('date', 'asc')
            ->orderBy('start_time', 'asc');
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    // Accessors
    public function getFormattedTimeAttribute(): string
    {
        $start = \Carbon\Carbon::parse($this->start_time)->format('H:i');
        $end = $this->end_time ? ' - ' . \Carbon\Carbon::parse($this->end_time)->format('H:i') : '';
        return $start . $end;
    }
}
