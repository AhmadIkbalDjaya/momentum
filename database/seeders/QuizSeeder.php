<?php

namespace Database\Seeders;

use App\Enums\QuizType;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use Illuminate\Database\Seeder;

class QuizSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Quiz::factory(12)->create()->each(function ($quiz) {
            Question::factory(10)->create([
                'quiz_id' => $quiz->id,
            ])->each(function ($question) use ($quiz) {

                if ($quiz->type === QuizType::MultipleChoice) {
                    $options = Option::factory(5)->create([
                        'question_id' => $question->id,
                    ]);

                    $optionCorect = $options->random();
                    $optionCorect->update(['is_correct' => true]);
                    $question->update(['correct_answer_id' => $optionCorect->id]);

                } elseif ($quiz->type === QuizType::TrueFalse) {
                    $options = Option::factory(2)->create([
                        'option' => 'Salah',
                        'question_id' => $question->id,
                    ]);

                    $optionCorect = $options->random();
                    $optionCorect->update([
                        'option' => 'Benar',
                        'is_correct' => true,
                    ]);
                    $question->update(['correct_answer_id' => $optionCorect->id]);
                }
            });
        });
    }
}
