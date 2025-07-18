<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Logbook extends Model
{
    use HasFactory, HasUuids, SoftDeletes;

    protected $table = 'logbooks';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'application_id',
        'tanggal',
        'deskripsi',
        'constraint',
    ];

    protected $casts = [
        'tanggal' => 'date',
    ];

    public function application(): BelongsTo
    {
        return $this->belongsTo(InternshipApplication::class);
    }
}
