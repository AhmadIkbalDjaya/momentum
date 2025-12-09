<?php

namespace App\Livewire\User\Components;

use App\Models\Quiz;

use Livewire\Component;

class QuizCard extends Component
{
    public Quiz $quiz;

    public function mount($quiz)
    {
        $this->quiz = $quiz;
    }

    public function render()
    {
        $rand_img = rand(1, 10);
        return view('livewire.user.components.quiz-card', [
            'rand_img' => $rand_img,
        ]);
    }
}
