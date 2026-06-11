<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Grade>
 */
class GradeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            // Kita batasi nama kelas hanya dari Kelas 1 sampai Kelas 6 agar realistis untuk SD
            'name' => $this->faker->randomElement([
                'Kelas 1', 
                'Kelas 2', 
                'Kelas 3', 
                'Kelas 4', 
                'Kelas 5', 
                'Kelas 6'
            ]),
        ];
    }
}