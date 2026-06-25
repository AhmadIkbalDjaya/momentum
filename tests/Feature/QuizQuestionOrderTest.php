<?php

namespace Tests\Feature;

use App\Enums\QuizType;
use App\Livewire\User\Quiz\Work;
use App\Models\Option;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\Student;
use App\Models\StudentQuiz;
use App\Support\QuizWorkAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class QuizQuestionOrderTest extends TestCase
{
    use RefreshDatabase;

    public function test_randomization_disabled_uses_normal_question_order(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz([
            'randomize_questions' => false,
        ]);
        $questions = $this->createQuestions($quiz, 3);

        $this->actingAs($student, 'student');
        QuizWorkAccess::grant($quiz, $student->id);

        $component = Livewire::test(Work::class, ['quiz' => $quiz]);
        $studentQuiz = StudentQuiz::whereBelongsTo($student)
            ->whereBelongsTo($quiz)
            ->firstOrFail();

        $this->assertSame(
            $questions->pluck('id')->all(),
            $component->get('questions')->pluck('id')->all(),
        );
        $this->assertNull($studentQuiz->question_order);
    }

    public function test_randomization_disabled_clears_existing_question_order(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz([
            'randomize_questions' => false,
        ]);
        $questions = $this->createQuestions($quiz, 4);

        StudentQuiz::create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'start_time' => now(),
            'question_order' => $questions->pluck('id')->reverse()->values()->all(),
        ]);

        $this->actingAs($student, 'student');
        QuizWorkAccess::grant($quiz, $student->id);

        $component = Livewire::test(Work::class, ['quiz' => $quiz]);
        $studentQuiz = StudentQuiz::whereBelongsTo($student)
            ->whereBelongsTo($quiz)
            ->firstOrFail();

        $this->assertSame(
            $questions->pluck('id')->all(),
            $component->get('questions')->pluck('id')->all(),
        );
        $this->assertNull($studentQuiz->question_order);
    }

    public function test_randomization_enabled_stores_question_order_for_attempt(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz([
            'randomize_questions' => true,
        ]);
        $questions = $this->createQuestions($quiz, 5);

        $this->actingAs($student, 'student');
        QuizWorkAccess::grant($quiz, $student->id);

        $component = Livewire::test(Work::class, ['quiz' => $quiz]);
        $studentQuiz = StudentQuiz::whereBelongsTo($student)
            ->whereBelongsTo($quiz)
            ->firstOrFail();

        $this->assertEqualsCanonicalizing(
            $questions->pluck('id')->all(),
            $studentQuiz->question_order,
        );
        $this->assertSame(
            $studentQuiz->question_order,
            $component->get('questions')->pluck('id')->all(),
        );
    }

    public function test_existing_attempt_question_order_is_reused_without_reshuffling(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz([
            'randomize_questions' => true,
        ]);
        $questions = $this->createQuestions($quiz, 4);
        $storedOrder = $questions->pluck('id')->reverse()->values()->all();

        StudentQuiz::create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'start_time' => now(),
            'question_order' => $storedOrder,
        ]);

        $this->actingAs($student, 'student');
        QuizWorkAccess::grant($quiz, $student->id);

        $component = Livewire::test(Work::class, ['quiz' => $quiz]);

        $this->assertSame($storedOrder, $component->get('questions')->pluck('id')->all());
    }

    public function test_answers_are_saved_against_displayed_random_question_order(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz([
            'randomize_questions' => true,
        ]);
        $questions = $this->createQuestions($quiz, 3);
        $storedOrder = [
            $questions[2]->id,
            $questions[0]->id,
            $questions[1]->id,
        ];

        StudentQuiz::create([
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
            'start_time' => now(),
            'question_order' => $storedOrder,
        ]);

        $this->actingAs($student, 'student');
        QuizWorkAccess::grant($quiz, $student->id);

        $component = Livewire::test(Work::class, ['quiz' => $quiz]);
        $displayedQuestions = $component->get('questions');
        $firstDisplayedQuestion = $displayedQuestions->first();
        $selectedOption = $firstDisplayedQuestion->options->first();

        $component
            ->set('selected_options.0', $selectedOption->id)
            ->call('save_answer');

        $this->assertDatabaseHas('student_quiz_answers', [
            'question_id' => $firstDisplayedQuestion->id,
            'option_id' => $selectedOption->id,
        ]);
        $this->assertDatabaseMissing('student_quiz_answers', [
            'question_id' => $questions[0]->id,
            'option_id' => $selectedOption->id,
        ]);
    }

    public function test_essay_quiz_forces_randomization_off_and_uses_normal_order(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz([
            'type' => QuizType::Essay,
            'randomize_questions' => true,
        ]);
        $questions = $this->createQuestions($quiz, 3, withOptions: false);

        $this->assertFalse($quiz->refresh()->randomize_questions);

        $this->actingAs($student, 'student');
        QuizWorkAccess::grant($quiz, $student->id);

        $component = Livewire::test(Work::class, ['quiz' => $quiz]);
        $studentQuiz = StudentQuiz::whereBelongsTo($student)
            ->whereBelongsTo($quiz)
            ->firstOrFail();

        $this->assertSame(
            $questions->pluck('id')->all(),
            $component->get('questions')->pluck('id')->all(),
        );
        $this->assertNull($studentQuiz->question_order);
    }

    /**
     * @return array{Student, Quiz}
     */
    private function createStudentAndQuiz(array $quizAttributes = []): array
    {
        $schoolCategory = SchoolCategory::create([
            'name' => 'Senior High',
        ]);

        $school = School::create([
            'name' => 'Momentum School',
            'school_category_id' => $schoolCategory->id,
        ]);

        $student = Student::create([
            'username' => 'student'.uniqid(),
            'password' => Hash::make('password'),
            'name' => 'Test Student',
            'gender' => 'male',
            'school_id' => $school->id,
        ]);

        $quiz = Quiz::create(array_merge([
            'name' => 'Question Order Quiz',
            'code' => 'ORDER-123',
            'school_category_id' => $schoolCategory->id,
            'type' => QuizType::MultipleChoice,
            'start_time' => now()->subMinute(),
            'end_time' => now()->addHour(),
            'duration' => 60,
            'is_active' => true,
            'show_score' => false,
            'randomize_questions' => false,
        ], $quizAttributes));

        return [$student, $quiz];
    }

    private function createQuestions(Quiz $quiz, int $count, bool $withOptions = true)
    {
        return collect(range(1, $count))->map(function (int $number) use ($quiz, $withOptions) {
            $question = Question::create([
                'quiz_id' => $quiz->id,
                'question' => "Question {$number}",
            ]);

            if ($withOptions) {
                $correctOption = Option::create([
                    'question_id' => $question->id,
                    'option' => "Option {$number} A",
                    'is_correct' => true,
                ]);

                Option::create([
                    'question_id' => $question->id,
                    'option' => "Option {$number} B",
                    'is_correct' => false,
                ]);

                $question->update([
                    'correct_answer_id' => $correctOption->id,
                ]);
            }

            return $question->refresh();
        });
    }
}
