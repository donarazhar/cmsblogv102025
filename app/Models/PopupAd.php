<?php

namespace App\Models;

use App\Traits\ClearsCache;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PopupAd extends Model
{
    use HasFactory, SoftDeletes, ClearsCache;

    protected $fillable = [
        'title',
        'subtitle',
        'banner_image',
        'pdf_file',
        'external_link',
        'target_routes',
        'is_active',
        'show_delay',
        'order',
        'start_date',
        'end_date',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'show_delay' => 'integer',
        'order' => 'integer',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

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

        $now = Carbon::now();

        if ($this->start_date && $this->start_date->isFuture()) {
            return false;
        }

        if ($this->end_date && $this->end_date->isPast()) {
            return false;
        }

        return true;
    }

    public function getTargetUrlAttribute(): ?string
    {
        if ($this->pdf_file) {
            return asset('storage/' . $this->pdf_file);
        }
        
        return $this->external_link;
    }

    // Route Matching
    public function matchesCurrentRoute(): bool
    {
        if (empty($this->target_routes)) {
            return true; // Match all if empty
        }

        $routes = array_map('trim', explode(',', $this->target_routes));

        foreach ($routes as $route) {
            // Laravel request()->is() mengecek path tanpa awalan slash (kecuali root '/')
            // Jadi jika admin menginput "/programs", kita ubah jadi "programs"
            if ($route !== '/') {
                $route = ltrim($route, '/');
            }
            
            if (request()->is($route)) {
                return true;
            }
        }

        return false;
    }
}
