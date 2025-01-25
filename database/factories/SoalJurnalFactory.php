<?php

namespace Database\Factories;

use App\Models\SoalJurnal;
use App\Models\SoalJurnals;
use Illuminate\Database\Eloquent\Factories\Factory;

class SoalJurnalFactory extends Factory
{
    protected $model = SoalJurnal::class;

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
