<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'url_link',
        'target_routes',
        'order',
        'is_active',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc')->orderBy('created_at', 'desc');
    }

    // Route Matching
    public function matchesCurrentRoute(): bool
    {
        if (empty($this->target_routes)) {
            return false; // For AdBanner, empty means it's a slider banner on homepage
        }

        $routes = array_map('trim', explode(',', $this->target_routes));

        foreach ($routes as $route) {
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
