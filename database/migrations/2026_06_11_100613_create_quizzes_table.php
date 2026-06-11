<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('quizzes', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key yang mengarah ke kolom 'id' di tabel 'meetings'
            $table->foreignId('meeting_id')->constrained()->cascadeOnDelete();
            
            // ENUM membatasi nilai hanya boleh 'latihan' atau 'pr'
            $table->enum('type', ['latihan', 'pr']);
            
            $table->string('title'); // Judul kuis, misal: "Latihan Penjumlahan Dasar"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('quizzes');
    }
};