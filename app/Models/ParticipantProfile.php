<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ParticipantProfile extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'user_id',
        'phone_number',
        'address',
        'birth_date',
        'gender',
        'university',
        'study_program',
        'portfolio_url',
        'photo',
        'cv',
        'gpa',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function applications(): HasMany
    {
        return $this->hasMany(InternshipApplication::class, 'participant_id');
    }

    public function isComplete(): bool
    {
        return $this->phone_number && $this->address && $this->birth_date && $this->gender &&
            $this->university && $this->study_program && $this->cv && $this->photo;
    }
}
