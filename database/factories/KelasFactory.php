<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Kelas>
 */
class KelasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            "kelas" => $this->faker->realText(10),
            "hari" => $this->faker->dayOfWeek,
            "shift" => $this->faker->numberBetween(1, 4),
            "totalGroup" => $this->faker->numberBetween(1, 20),
            "created_at" => now(),
            "updated_at" => now(),
        ];
    }
}
