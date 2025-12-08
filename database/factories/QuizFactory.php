<?php

namespace Database\Factories;

use App\Models\QuizType;
use App\Models\SchoolCategory;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Quiz>
 */
class QuizFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Generate start & end time
        $start = $this->faker->dateTimeBetween('+0 day', '+2 days');
        $end = (clone $start)->modify('+1 hour');

        return [
            'name' => $this->faker->words(3, true),
            'code' => strtoupper($this->faker->unique()->bothify('QUIZ-###??')),
            'school_category_id' => SchoolCategory::select('id')->inRandomOrder()->first()->id,
            'quiz_type_id' => QuizType::select('id')->inRandomOrder()->first()->id,
            'start_time' => $start,
            'end_time' => $end,
            'duration' => 60,
            'is_active' => $this->faker->boolean(),
            'show_score' => $this->faker->boolean(),
        ];
    }
}
