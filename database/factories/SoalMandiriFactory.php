<?php

namespace Database\Factories;

use App\Models\SoalMandiri;
use App\Models\SoalMandiris;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalMandiriFactory extends Factory
{
    protected $model = SoalMandiri::class;

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
