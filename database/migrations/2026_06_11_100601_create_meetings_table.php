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
        Schema::create('meetings', function (Blueprint $table) {
            $table->id();
            
            // Foreign Key yang mengarah ke kolom 'id' di tabel 'topics'
            $table->foreignId('topic_id')->constrained()->cascadeOnDelete();
            
            $table->string('title'); // Judul pertemuan, misal: "Pertemuan 1"
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meetings');
    }
};