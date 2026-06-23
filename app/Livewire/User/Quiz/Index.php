<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout('components.layouts.base_layout')]
    public function render()
    {
        $user_school_category_id = auth()->guard('student')->user()->school->school_category_id;

        $quizzes = Quiz::select(['id', 'name', 'duration', 'type'])
            ->active()
            ->bySchoolCategory($user_school_category_id)
            ->with([
                'student_quiz' => function ($query) {
                    $query->select(['id', 'student_id', 'quiz_id', 'is_done'])
                        ->where('student_id', auth()->guard('student')->user()->id);
                },
            ])
            ->withCount('questions')
            ->get();

        return view('livewire.user.quiz.index', [
            'quizzes' => $quizzes,
        ])->title('Quiz');
    }
}
