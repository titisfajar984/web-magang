<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParticipantProfile extends Model
{
    use HasFactory;
    protected $table = 'participant_profiles';
    public $incrementing = false;
    protected $keyType = 'uuid';
    protected $fillable = [
        'id', 'user_id', 'no_telepon', 'alamat', 'tanggal_lahir', 'jenis_kelamin', 'university', 'program_studi', 'foto', 'cv', 'transkrip', 'portofolio'
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = (string) \Illuminate\Support\Str::uuid();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function applications()
    {
        return $this->hasMany(IntershipsApplication::class, 'participant_id');
    }
}
