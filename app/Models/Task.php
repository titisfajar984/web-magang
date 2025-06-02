<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Concerns\HasUuids;

class Task extends Model
{
    use HasFactory, HasUuids;

    protected $fillable = [
        'application_id',
        'name',
        'description',
        'deadline',
        'status',
        'file_path'
    ];

    protected $casts = [
        'deadline' => 'date'
    ];

    public function application()
    {
        return $this->belongsTo(InternshipApplication::class, 'application_id');
    }

    public function submissions()
    {
        return $this->hasMany(TaskSubmission::class);
    }

}
