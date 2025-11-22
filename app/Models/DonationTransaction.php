<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class DonationTransaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'transaction_code',
        'donation_id',
        'user_id',
        'donor_name',
        'donor_email',
        'donor_phone',
        'amount',
        'payment_method',
        'payment_proof',
        'status',
        'notes',
        'admin_notes',
        'is_anonymous',
        'paid_at',
        'verified_at',
        'verified_by',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'amount' => 'decimal:2',
        'paid_at' => 'datetime',
        'verified_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    // Relationships
    public function donation(): BelongsTo
    {
        return $this->belongsTo(Donation::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function verifier(): BelongsTo
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    // Scopes
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeVerified($query)
    {
        return $query->where('status', 'verified');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    public function scopeLatest($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    public function updateAmount($amount)
    {
        // Increment or decrement current amount
        $this->increment('current_amount', $amount);

        // Update progress percentage
        if ($this->target_amount > 0) {
            $this->progress_percentage = min(($this->current_amount / $this->target_amount) * 100, 100);
            $this->save();
        }

        // Update donor count if adding
        if ($amount > 0) {
            $this->increment('donor_count');
        }
    }

    // app/Models/DonationTransaction.php

    public function verify($verifier_id)
    {
        $this->update([
            'status' => 'verified',
            'verified_at' => now(),
            'verified_by' => $verifier_id,
        ]);

        // Update donation amount
        $this->donation->updateAmount($this->amount);
    }

    public function reject($admin_notes = null)
    {
        $this->update([
            'status' => 'rejected',
            'admin_notes' => $admin_notes,
        ]);
    }

    // Boot method
    protected static function boot()
    {
        parent::boot();

        static::creating(function ($transaction) {
            if (!$transaction->transaction_code) {
                $transaction->transaction_code = 'DN' . date('Ymd') . strtoupper(Str::random(6));
            }
        });
    }
}
