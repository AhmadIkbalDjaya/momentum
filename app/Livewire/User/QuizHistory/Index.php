<?php

namespace App\Livewire\User\QuizHistory;

use App\Http\Resources\User\StudentQuizzesResource;
use App\Models\StudentQuiz;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.base_layout')]

    public function render()
    {
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

        return view('livewire.user.quiz-history.index', [
            'student_quizzes' => StudentQuizzesResource::collection($student_quizzes)->resolve(),
        ])->title('History');
    }
}
