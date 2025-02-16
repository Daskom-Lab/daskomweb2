<?php

namespace Database\Factories;

use App\Models\SoalTa;
use App\Models\SoalTas;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalTaFactory extends Factory
{
    protected $model = SoalTa::class;

    public function definition()
    {
        return [
            'modul_id' => $this->faker->numberBetween(11, 15),
            'pengantar' => $this->faker->paragraph,
            'kodingan' => $this->faker->sentence,
            'pertanyaan' => $this->faker->sentence,
            'jawaban_benar' => $this->faker->sentence,
            'jawaban_salah1' => $this->faker->sentence,
            'jawaban_salah2' => $this->faker->sentence,
            'jawaban_salah3' => $this->faker->sentence,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
