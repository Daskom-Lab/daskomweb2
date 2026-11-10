<?php

namespace Database\Factories;

use App\Models\Kelas;
use App\Models\Praktikan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Praktikan>
 */
class PraktikanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name,
            'nim' => $this->faker->unique()->numerify('##########'), // 10 digit, unik karena kolom nim ber-index unique
            'password' => bcrypt('password'), // Default password for testing
            'kelas_id' => Kelas::factory(),
            'dk' => $this->faker->randomElement(['DK1', 'DK2']),
            'alamat' => $this->faker->address,
            'nomor_telepon' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
    public function withRole()
    {
        return $this->afterCreating(function (Praktikan $praktikan) {
            $praktikan->assignRole('PRAKTIKAN');
    });
}
}
