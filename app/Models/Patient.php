<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'address_proof_type',
        'address_proof_file',
        'agent_id',
        'status',
        'card_type',
        'primary_member_id',
        'profile_image',
        'qr_code',
        'card_validity_date',
    ];

    protected $casts = [
        'card_validity_date' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function agent(): BelongsTo
    {
        return $this->belongsTo(Agent::class);
    }

    public function visits(): HasMany
    {
        return $this->hasMany(Visit::class);
    }

    // For family cards: relationship to primary member
    public function primaryMember(): BelongsTo
    {
        return $this->belongsTo(Patient::class, 'primary_member_id');
    }

    // Get all family members if this is primary card
    public function familyMembers(): HasMany
    {
        return $this->hasMany(Patient::class, 'primary_member_id');
    }

    // Check if this is primary member of a family
    public function isPrimaryMember(): bool
    {
        return $this->card_type === 'family' && $this->primary_member_id === null;
    }

    // Get all members including self for family cards
    public function getAllCardMembers()
    {
        if ($this->card_type === 'individual') {
            return collect([$this]);
        }

        if ($this->isPrimaryMember()) {
            return $this->familyMembers()->with('user')->get()->prepend($this);
        }

        return $this->primaryMember->familyMembers()->with('user')->get()->prepend($this->primaryMember);
    }
}
