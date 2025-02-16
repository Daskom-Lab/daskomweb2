<?php

namespace Database\Factories;

use App\Models\SoalFitb;
use App\Models\SoalFitbs;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalFitbFactory extends Factory
{
    protected $model = SoalFitb::class;

    public function definition()
    {
        return [
            'modul_id' => $this->faker->numberBetween(11, 15),
            'pengantar' => $this->faker->paragraph,
            'kodingan' => $this->faker->sentence,
            'soal' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
