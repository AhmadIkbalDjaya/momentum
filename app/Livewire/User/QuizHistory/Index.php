<?php

namespace App\Livewire\User\QuizHistory;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Index extends Component
{
    #[Layout("components.layouts.base_layout")]
    public function render()
    {
        return view('livewire.user.quiz-history.index');
    }
}