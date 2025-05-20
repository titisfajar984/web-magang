<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'internship_id',
        'name',
        'description',
        'deadline',
        'status',
        'file_path'
    ];

    protected $casts = [
        'deadline' => 'date'
    ];

    public function internship()
    {
        return $this->belongsTo(InternshipPosting::class);
    }

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function participant()
    {
        return $this->belongsTo(ParticipantProfile::class, 'participant_id');
    }

}
