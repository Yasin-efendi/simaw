<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class AttemptAnswer extends Model
{
    use HasFactory;

    /**
     * Nama tabel secara eksplisit untuk kejelasan.
     */
    protected $table = 'attempt_answers';

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'attempt_id',
        'question_id',
        'selected_answer',
        'is_correct',
    ];

    /**
     * Relasi: Satu AttemptAnswer milik satu StudentAttempt (Sesi pengerjaan).
     */
    public function attempt(): BelongsTo
    {
        return $this->belongsTo(StudentAttempt::class, 'attempt_id');
    }

    /**
     * Relasi: Satu AttemptAnswer milik satu Question (Soal yang dijawab).
     */
    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }
}