<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AdBanner extends Model
{
    protected $fillable = [
        'title',
        'image',
        'url_link',
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
}
