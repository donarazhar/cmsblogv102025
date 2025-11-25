<?php

namespace App\Models;

use App\Traits\ClearsCache;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgramRegistration extends Model
{
    use HasFactory, ClearsCache;

    protected $fillable = [
        'program_id',
        'name',
        'email',
        'phone',
        'notes',
        'status',
    ];

    /**
     * Relationships
     */
    public function program()
    {
        return $this->belongsTo(Program::class);
    }
}