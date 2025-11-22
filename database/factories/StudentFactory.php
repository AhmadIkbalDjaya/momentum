<?php

namespace Database\Factories;

use App\Models\School;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Student>
 */
class StudentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->name();
        return [
            'username' => Str::lower(str_replace(' ', '', $name)),
            'password' => Hash::make('password'),
            'name' => $name,
            'gender' => $this->faker->randomElement(['male', 'female']),
            'school_id' => School::select("id")->inRandomOrder()->first()->id ?? School::factory()->create()->id, // auto-create school
        ];
    }
}
