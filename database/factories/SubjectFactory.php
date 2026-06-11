<?php

namespace Database\Factories;

use App\Models\Grade;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Subject>
 */
class SubjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Mengambil grade_id secara acak dari tabel grades yang sudah ada.
            // Jika tabel grades masih kosong, dia akan membuat Grade baru sebagai fallback.
            'grade_id' => Grade::inRandomOrder()->first()?->id ?? Grade::factory(),
            
            // Daftar mata pelajaran umum di Sekolah Dasar
            'name' => $this->faker->randomElement([
                'Matematika',
                'Bahasa Indonesia',
                'Ilmu Pengetahuan Alam (IPA)',
                'Ilmu Pengetahuan Sosial (IPS)',
                'Pendidikan Kewarganegaraan (PKn)',
                'Seni Budaya dan Prakarya (SBdP)',
                'Pendidikan Jasmani, Olahraga, dan Kesehatan (PJOK)',
                'Bahasa Inggris',
                'Agama',
            ]),
        ];
    }
}