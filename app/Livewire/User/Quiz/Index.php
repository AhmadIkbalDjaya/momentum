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

        $quizzes = Quiz::select(['id', 'name', 'duration', 'quiz_type_id'])
            ->with(['quiz_type:id,description'])
            ->where('is_active', 1)
            ->where('school_category_id', $user_school_category_id)
            ->get();
        
        return view('livewire.user.quiz.index', [
            'quizzes' => $quizzes,
        ])->title('Quiz');
    }
}
