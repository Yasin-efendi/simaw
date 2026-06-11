<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'meeting_id',
        'type',
        'title',
    ];

    /**
     * Relasi: Satu Quiz milik satu Meeting.
     */
    public function meeting(): BelongsTo
    {
        return $this->belongsTo(Meeting::class);
    }

    /**
     * Relasi: Satu Quiz memiliki banyak Question (Soal).
     */
    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    /**
     * Relasi: Satu Quiz memiliki banyak StudentAttempt (Riwayat pengerjaan).
     */
    public function studentAttempts(): HasMany
    {
        return $this->hasMany(StudentAttempt::class);
    }
}