<?php

namespace Database\Factories;

use App\Models\Subject;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Topic>
 */
class TopicFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Mengambil subject_id secara acak dari tabel subjects yang sudah ada.
            'subject_id' => Subject::inRandomOrder()->first()?->id ?? Subject::factory(),
            
            // Daftar judul bab/topik yang realistis untuk SD
            'title' => $this->faker->randomElement([
                'Penjumlahan dan Pengurangan',
                'Perkalian dan Pembagian',
                'Makhluk Hidup dan Lingkungannya',
                'Sistem Tata Surya',
                'Pahlawan Nasional',
                'Keragaman Budaya Indonesia',
                'Membaca Teks Fiksi',
                'Menulis Puisi',
                'Hak dan Kewajiban Warga Negara',
                'Gerak dan Gaya',
            ]),
        ];
    }
}