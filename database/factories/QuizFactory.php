<?php

namespace Database\Factories;

use App\Models\Meeting;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Mengambil meeting_id secara acak dari tabel meetings yang sudah ada.
            'meeting_id' => Meeting::inRandomOrder()->first()?->id ?? Meeting::factory(),
            
            // Tipe kuis hanya boleh 'latihan' atau 'pr'
            'type' => $this->faker->randomElement(['latihan', 'pr']),
            
            // Menggunakan Closure untuk membuat judul yang dinamis dan realistis
            'title' => function (array $attributes) {
                // Ambil data Meeting berdasarkan meeting_id yang baru saja di-generate
                $meeting = Meeting::find($attributes['meeting_id']);
                
                // Ambil judul topic dari meeting tersebut (jika ada)
                $topicTitle = $meeting?->topic?->title ?? 'Materi Umum';
                
                // Rangkai judul berdasarkan tipe kuis
                $prefix = $attributes['type'] === 'latihan' ? 'Latihan Soal' : 'Pekerjaan Rumah (PR)';
                
                return "{$prefix} - {$topicTitle}";
            },
        ];
    }
}