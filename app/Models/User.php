<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use App\Traits\ClearsCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Spatie\Activitylog\LogOptions; // ✅ TAMBAHKAN
use Spatie\Activitylog\Traits\LogsActivity; // ✅ TAMBAHKAN

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, LogsActivity, ClearsCache;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'email_verified_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'password' => 'hashed',
            'email_verified_at' => 'datetime:Asia/Jakarta',
            'created_at' => 'datetime:Asia/Jakarta',
            'updated_at' => 'datetime:Asia/Jakarta',
        ];
    }
    // ✅ TAMBAHKAN METHOD INI
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name', 'email'])
            ->logOnlyDirty();
    }

    public function actions()
    {
        return $this->morphMany(\Spatie\Activitylog\Models\Activity::class, 'causer');
    }

    /**
     * Check if user is Administrator
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Check if user is Staff
     */
    public function isStaff(): bool
    {
        return $this->role === 'staff';
    }
}
