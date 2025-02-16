<?php

namespace Database\Factories;

use App\Models\SoalTp;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalTpFactory extends Factory
{
    protected $model = SoalTp::class;

    public function definition()
    {
        return [
            'modul_id' => $this->faker->numberBetween(11,15),
            'soal' => $this->faker->sentence,
            'isEssay' => $this->faker->boolean,
            'isProgram' => $this->faker->boolean,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
