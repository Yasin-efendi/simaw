<?php

namespace Database\Seeders;

use App\Models\Grade;
use App\Models\Meeting;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\Subject;
use App\Models\Topic;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Kita buat 2 Kelas (Grade)
        Grade::factory()
            ->count(2)
            ->has(
                // Setiap Kelas punya 2 Mata Pelajaran (Subject)
                Subject::factory()
                    ->count(2)
                    ->has(
                        // Setiap Mata Pelajaran punya 2 Bab (Topic)
                        Topic::factory()
                            ->count(2)
                            ->has(
                                // Setiap Bab punya 2 Pertemuan (Meeting)
                                Meeting::factory()
                                    ->count(2)
                                    ->has(
                                        // Setiap Pertemuan punya 2 Kuis (Quiz)
                                        Quiz::factory()
                                            ->count(2)
                                            ->has(
                                                // Setiap Kuis punya 5 Soal (Question)
                                                Question::factory()->count(5)
                                            )
                                    )
                            )
                    )
            )
            ->create();

        $this->command->info('✅ Data dummy berhasil dibuat dengan hierarki yang lengkap!');
    }
}