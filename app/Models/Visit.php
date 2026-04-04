<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Model;

class Visit extends Model
{
    protected $fillable = [
        'patient_id',
        'vendor_id',
        'discount_percentage',
        'discount_amount',
        'original_amount',
        'service_type',
        'notes',
        'verification_method',
        'visited_at',
    ];

    protected $casts = [
        'visited_at' => 'datetime',
        'discount_amount' => 'decimal:2',
        'original_amount' => 'decimal:2',
    ];

    public function patient(): BelongsTo
    {
        return $this->belongsTo(Patient::class);
    }

    public function vendor(): BelongsTo
    {
        return $this->belongsTo(Vendor::class);
    }
}
