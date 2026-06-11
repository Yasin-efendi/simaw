<?php

namespace Database\Factories;

use App\Models\Quiz;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Kumpulan paket soal yang logis dan koheren (Pertanyaan + Opsi + Kunci + Pembahasan)
        $questionSets = [
            [
                'question' => 'Berapakah hasil dari 8 x 7?',
                'options' => ['54', '56', '64', '48'],
                'correct' => 'B',
                'explanation' => '8 dikalikan 7 sama dengan 56.'
            ],
            [
                'question' => 'Hewan yang memakan tumbuhan disebut...',
                'options' => ['Karnivora', 'Herbivora', 'Omnivora', 'Insektivora'],
                'correct' => 'B',
                'explanation' => 'Herbivora adalah sebutan untuk hewan pemakan tumbuhan.'
            ],
            [
                'question' => 'Lambang negara Indonesia adalah...',
                'options' => ['Garuda Pancasila', 'Bendera Merah Putih', 'Padi dan Kapas', 'Pohon Beringin'],
                'correct' => 'A',
                'explanation' => 'Garuda Pancasila adalah lambang negara Republik Indonesia.'
            ],
            [
                'question' => 'Ibu kota provinsi Jawa Barat adalah...',
                'options' => ['Jakarta', 'Surabaya', 'Bandung', 'Semarang'],
                'correct' => 'C',
                'explanation' => 'Bandung adalah ibu kota provinsi Jawa Barat.'
            ],
            [
                'question' => 'Bahasa Inggris dari "Buku" adalah...',
                'options' => ['Pen', 'Book', 'Bag', 'Desk'],
                'correct' => 'B',
                'explanation' => 'Dalam bahasa Inggris, "Buku" disebut "Book".'
            ]
        ];

        // Pilih satu paket soal secara acak
        $set = $this->faker->randomElement($questionSets);

        return [
            // Mengambil quiz_id secara acak dari tabel quizzes yang sudah ada.
            'quiz_id' => Quiz::inRandomOrder()->first()?->id ?? Quiz::factory(),
            
            'question_text' => $set['question'],
            'option_a' => $set['options'][0],
            'option_b' => $set['options'][1],
            'option_c' => $set['options'][2],
            'option_d' => $set['options'][3],
            
            'correct_answer' => $set['correct'],
            
            // Pembahasan diisi, tapi sesekali kita buat null (20% kemungkinan) untuk menguji UI
            'explanation' => $this->faker->boolean(80) ? $set['explanation'] : null,
            
            // Gambar opsional, sesekali ada (10% kemungkinan)
            'image_path' => $this->faker->boolean(10) ? 'images/dummy-soal.jpg' : null,
        ];
    }
}