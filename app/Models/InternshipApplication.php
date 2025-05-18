<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class InternshipApplication extends Model
{
    use HasFactory, HasUuids;

    protected $table = 'internship_applications';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'id',
        'internship_posting_id',
        'participant_id',
        'status',
        'tanggal',
    ];

    public function internship(): BelongsTo
    {
        return $this->belongsTo(InternshipPosting::class, 'internship_posting_id');
    }

    public function participant(): BelongsTo
    {
        return $this->belongsTo(ParticipantProfile::class, 'participant_id');
    }
}
