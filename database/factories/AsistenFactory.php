<?php

namespace Database\Factories;


use Spatie\Permission\Models\Role;
use App\Models\Asisten;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class AsistenFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => $this->faker->name(),
            'kode' => Str::upper(Str::random(3)), // Generates a random 3-letter uppercase string
            'role_id' => $this->faker->numberBetween(1,6),
            'nomor_telepon' => $this->faker->phoneNumber(),
            'id_line' => $this->faker->unique()->userName(),
            'instagram' => $this->faker->unique()->userName(),
            'deskripsi' => ' ',
            'password' => Hash::make('password'),              // Default password for testing
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }

    public function withRoles(array $roleName)
    {
        return $this->afterCreating(function (Asisten $asisten) use ($roleName) {
            // Assign role in Spatie
            $asisten->assignRole($role);

            // // Sync `role_id` in the asistens table
            // if (!$asisten->role_id) {
            //     $asisten->role_id = $role->id;
            //     $asisten->save();
            // }

        });
    }

   
}
