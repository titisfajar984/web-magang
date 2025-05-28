<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FinalReport extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'finalreport';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'application_id',
        'description',
        'file_path',
        'submission_date',
        'status',
        'feedback',
    ];

    protected $casts = [
        'submission_date' => 'datetime',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class);
    }
}
