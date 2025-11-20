<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'file_name',
        'mime_type',
        'path',
        'disk',
        'collection',
        'size',
        'properties',
        'uploaded_by',
    ];

    protected $casts = [
        'size' => 'integer',
        'properties' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $appends = ['url', 'size_formatted'];

    // Relationships
    public function uploader(): BelongsTo
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    // Scopes
    public function scopeImages($query)
    {
        return $query->where('mime_type', 'like', 'image/%');
    }

    public function scopeDocuments($query)
    {
        return $query->whereIn('mime_type', [
            'application/pdf',
            'application/msword',
            'application/vnd.openxmlformats-officedocument.wordprocessingml.document',
        ]);
    }

    public function scopeByCollection($query, $collection)
    {
        return $query->where('collection', $collection);
    }

    // Accessors
    public function getUrlAttribute(): string
    {
        return Storage::disk($this->disk)->url($this->path);
    }

    public function getSizeFormattedAttribute(): string
    {
        $size = $this->size;
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $size > 1024; $i++) {
            $size /= 1024;
        }

        return round($size, 2) . ' ' . $units[$i];
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($media) {
            Storage::disk($media->disk)->delete($media->path);
        });
    }
}
