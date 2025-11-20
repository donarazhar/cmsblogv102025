<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Contact extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status',
        'admin_reply',
        'replied_at',
        'replied_by',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'replied_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function replier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'replied_by');
    }

    // Scopes
    public function scopeNew($query)
    {
        return $query->where('status', 'new');
    }

    public function scopeRead($query)
    {
        return $query->where('status', 'read');
    }

    public function scopeReplied($query)
    {
        return $query->where('status', 'replied');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    // Methods
    public function markAsRead()
    {
        if ($this->status === 'new') {
            $this->update(['status' => 'read']);
        }
    }

    public function reply($reply, $user_id)
    {
        $this->update([
            'status' => 'replied',
            'admin_reply' => $reply,
            'replied_at' => now(),
            'replied_by' => $user_id,
        ]);
    }

    public function archive()
    {
        $this->update(['status' => 'archived']);
    }
}
