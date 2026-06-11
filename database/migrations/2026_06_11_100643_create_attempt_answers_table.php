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
        Schema::create('attempt_answers', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key ke tabel 'student_attempts'
            // PENTING: Kita harus menyebutkan nama tabel 'student_attempts' secara eksplisit
            // karena tidak mengikuti konvensi penamaan default Laravel ('attempts')
            $table->foreignId('attempt_id')->constrained('student_attempts')->cascadeOnDelete();
            
            // Foreign Key ke tabel 'questions'
            $table->foreignId('question_id')->constrained()->cascadeOnDelete();
            
            // Jawaban yang dipilih siswa (A, B, C, D). Nullable jika siswa melewatkan soal.
            $table->enum('selected_answer', ['A', 'B', 'C', 'D'])->nullable();
            
            // Status kebenaran jawaban (true = benar, false = salah)
            $table->boolean('is_correct')->default(false);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attempt_answers');
    }
};