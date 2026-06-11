<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Subject extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal.
     */
    protected $fillable = [
        'grade_id',
        'name',
    ];

    /**
     * Relasi: Satu Subject milik satu Grade.
     */
    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }

    /**
     * Relasi: Satu Subject memiliki banyak Topic.
     */
    public function topics(): HasMany
    {
        return $this->hasMany(Topic::class);
    }
}