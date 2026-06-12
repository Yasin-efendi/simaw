<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class StudentAttempt extends Model
{
    use HasFactory;

    /**
     * Nama tabel secara eksplisit (Best Practice untuk kejelasan)
     */
    protected $table = 'student_attempts';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'quiz_id',
        'student_name',
        'absence_number',
        'score',
    ];

    /**
     * Relasi: Satu StudentAttempt milik satu Quiz.
     */
    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    /**
     * Relasi: Satu StudentAttempt memiliki banyak AttemptAnswer (Detail Jawaban).
     * PENTING: Sebutkan nama kolom foreign key 'attempt_id' secara eksplisit untuk menghindari kesalahan relasi.
     */
    public function attemptAnswers(): HasMany
    {
        return $this->hasMany(AttemptAnswer::class, 'attempt_id');
    }
}