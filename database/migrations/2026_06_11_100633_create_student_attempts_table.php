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
        Schema::create('student_attempts', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key yang mengarah ke kolom 'id' di tabel 'quizzes'
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            
            $table->string('student_name');       // Nama siswa yang diinput
            $table->integer('absence_number');    // Nomor absen
            $table->integer('score');             // Nilai akhir (misal: 80)
            
            // RULE PENTING: Kombinasi 3 kolom ini harus unik
            $table->unique(['quiz_id', 'student_name', 'absence_number'], 'unique_student_attempt');
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('student_attempts');
    }
};