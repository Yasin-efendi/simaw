<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Grade extends Model
{
    use HasFactory;

    /**
     * Kolom yang boleh diisi secara massal (Mass Assignment).
     */
    protected $fillable = [
        'name',
    ];

    /**
     * Relasi: Satu Grade memiliki banyak Subject.
     */
    public function subjects(): HasMany
    {
        return $this->hasMany(Subject::class);
    }
}