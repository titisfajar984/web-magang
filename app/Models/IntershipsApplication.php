<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IntershipsApplication extends Model
{
    use HasFactory;
    protected $table = 'internship_applications';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id', 'internship_posting_id', 'participant_id', 'status', 'tanggal'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function internship()
    {
        return $this->belongsTo(InternshipPosting::class, 'internship_posting_id');
    }


    public function participant()
    {
        return $this->belongsTo(ParticipantProfile::class, 'participant_id');
    }
}
