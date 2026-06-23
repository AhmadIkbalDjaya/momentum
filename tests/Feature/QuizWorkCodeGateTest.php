<?php

namespace Tests\Feature;

use App\Enums\QuizType;
use App\Livewire\User\Quiz\Show;
use App\Livewire\User\Quiz\Work;
use App\Models\Quiz;
use App\Models\School;
use App\Models\SchoolCategory;
use App\Models\Student;
use App\Support\QuizWorkAccess;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Livewire\Livewire;
use Tests\TestCase;

class QuizWorkCodeGateTest extends TestCase
{
    use RefreshDatabase;

    public function test_direct_work_access_without_code_shows_gate(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz();

        $this->actingAs($student, 'student')
            ->get(route('quiz.work', ['quiz' => $quiz->id]))
            ->assertOk()
            ->assertSee('Masukkan Kode Quiz');
    }

    public function test_direct_work_access_without_code_does_not_create_student_quiz(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz();

        $this->actingAs($student, 'student')
            ->get(route('quiz.work', ['quiz' => $quiz->id]))
            ->assertOk();

        $this->assertDatabaseMissing('student_quizzes', [
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
        ]);
    }

    public function test_wrong_code_keeps_work_page_gated(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz();

        $this->actingAs($student, 'student');

        Livewire::test(Work::class, ['quiz' => $quiz])
            ->set('quiz_code', 'WRONG-CODE')
            ->call('checkCode')
            ->assertHasErrors(['quiz_code'])
            ->assertSee('Masukkan Kode Quiz');

        $this->assertFalse(QuizWorkAccess::allows($quiz, $student->id));
        $this->assertDatabaseMissing('student_quizzes', [
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
        ]);
    }

    public function test_correct_code_on_work_page_grants_access_and_loads_quiz(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz();

        $this->actingAs($student, 'student');

        Livewire::test(Work::class, ['quiz' => $quiz])
            ->set('quiz_code', $quiz->code)
            ->call('checkCode')
            ->assertRedirect(route('quiz.work', ['quiz' => $quiz->id]));

        $this->assertTrue(QuizWorkAccess::allows($quiz, $student->id));

        $this->get(route('quiz.work', ['quiz' => $quiz->id]))
            ->assertOk()
            ->assertSee($quiz->name)
            ->assertDontSee('Masukkan Kode Quiz');

        $this->assertDatabaseHas('student_quizzes', [
            'student_id' => $student->id,
            'quiz_id' => $quiz->id,
        ]);
    }

    public function test_correct_code_on_detail_page_grants_access_before_redirect(): void
    {
        [$student, $quiz] = $this->createStudentAndQuiz();

        $this->actingAs($student, 'student');

        Livewire::test(Show::class, ['quiz' => $quiz])
            ->call('checkCode', $quiz->code)
            ->assertRedirect(route('quiz.work', ['quiz' => $quiz->id]));

        $this->assertTrue(QuizWorkAccess::allows($quiz, $student->id));
    }

    /**
     * @return array{Student, Quiz}
     */
    private function createStudentAndQuiz(): array
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

        $quiz = Quiz::create([
            'name' => 'Secure Quiz',
            'code' => 'SECURE-123',
            'school_category_id' => $schoolCategory->id,
            'type' => QuizType::MultipleChoice,
            'start_time' => now()->subMinute(),
            'end_time' => now()->addHour(),
            'duration' => 60,
            'is_active' => true,
            'show_score' => false,
        ]);

        return [$student, $quiz];
    }
}
