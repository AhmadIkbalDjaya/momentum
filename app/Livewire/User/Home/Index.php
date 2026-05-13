<?php

namespace App\Livewire\User\Home;

use App\Http\Resources\User\AuthProfileResource;
use App\Http\Resources\User\StudentQuizzesResource;
use App\Models\Quiz;
use App\Models\Student;
use App\Models\StudentQuiz;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.base_layout')]
    public function render()
    {
        $authUser = Student::where('id', Auth::guard('student')->user()->id)
            ->select('id', 'name', 'username', 'gender', 'school_id')
            ->with([
                'school:id,name,school_category_id',
                'quizzes:id',
            ])
            ->withCount([
                'quizzes as quiz_count',
                'student_quiz_answers as answers_count' => function ($query) {
                    $query->whereHas('student_quiz', function ($subQuery) {
                        $subQuery->where('student_id', Auth::guard('student')->user()->id);
                    });
                },
            ])
            ->first();

        $auth = (new AuthProfileResource($authUser))->resolve();

        $quizzes = Quiz::select(['id', 'name', 'duration', 'is_active', 'school_category_id', 'quiz_type_id'])
            ->where('is_active', 1)
            ->where('school_category_id', $authUser->school->school_category_id)
            ->with(['quiz_type:id,name,description'])
            ->limit(3)
            ->get();

        $student_quizzes = StudentQuiz::select(['id', 'student_id', 'quiz_id', 'start_time', 'duration', 'score'])
            ->with([
                'student:id,name',
                'quiz:id,name,quiz_type_id,show_score',
                'quiz.quiz_type:id,description',
                'quiz.questions:id,quiz_id',
            ])
            ->withCount([
                'student_quiz_answers as answer_count',
            ])
            ->where('student_id', auth()->guard('student')->user()->id)
            ->where('is_done', 1)
            ->get();

        return view('livewire.user.home.index', [
            'quizzes' => $quizzes,
            'auth' => $auth,
            'student_quizzes' => StudentQuizzesResource::collection($student_quizzes)->resolve(),
        ])->title('Home');
    }
}
