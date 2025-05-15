<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class CompanyProfile extends Model
{
    use HasFactory;

    protected $table = 'company_profiles';
    public $incrementing = false;
    protected $keyType = 'uuid';

    protected $fillable = [
        'id', 'user_id', 'name', 'deskripsi', 'alamat',
    ];

    protected static function boot()
    {
        parent::boot();
        static::creating(function ($model) {
            $model->id = Str::uuid()->toString();
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function internships()
    {
        return $this->hasMany(InternshipPosting::class, 'company_id');
    }

}
