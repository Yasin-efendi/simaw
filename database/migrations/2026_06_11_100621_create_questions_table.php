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
        Schema::create('questions', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key yang mengarah ke kolom 'id' di tabel 'quizzes'
            $table->foreignId('quiz_id')->constrained()->cascadeOnDelete();
            
            $table->text('question_text'); // Teks pertanyaan (bisa panjang)
            $table->text('option_a');      // Opsi jawaban A
            $table->text('option_b');      // Opsi jawaban B
            $table->text('option_c');      // Opsi jawaban C
            $table->text('option_d');      // Opsi jawaban D
            
            // Kunci jawaban dibatasi hanya A, B, C, atau D
            $table->enum('correct_answer', ['A', 'B', 'C', 'D']);
            
            $table->text('explanation')->nullable(); // Pembahasan (opsional)
            $table->string('image_path')->nullable(); // Path gambar soal (opsional)
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};