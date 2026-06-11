<?php

namespace Database\Factories;

use App\Models\Topic;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Meeting>
 */
class MeetingFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Mengambil topic_id secara acak dari tabel topics yang sudah ada.
            'topic_id' => Topic::inRandomOrder()->first()?->id ?? Topic::factory(),
            
            // Daftar judul pertemuan yang realistis sesuai RPP SD
            'title' => $this->faker->randomElement([
                'Pertemuan 1: Pengenalan Konsep Dasar',
                'Pertemuan 2: Latihan Soal dan Diskusi',
                'Pertemuan 3: Penerapan dalam Kehidupan Sehari-hari',
                'Pertemuan 4: Evaluasi dan Review Bab',
                'Pertemuan 5: Praktikum / Kegiatan Kelompok',
            ]),
        ];
    }
}