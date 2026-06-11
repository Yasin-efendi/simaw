<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Meeting extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'topic_id',
        'title',
    ];

    /**
     * Relasi: Satu Meeting milik satu Topic.
     */
    public function topic(): BelongsTo
    {
        return $this->belongsTo(Topic::class);
    }

    /**
     * Relasi: Satu Meeting memiliki banyak Quiz.
     */
    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }
}