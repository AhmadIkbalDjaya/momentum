<?php

namespace App\Livewire\User\Quiz;

use Livewire\Attributes\Layout;
use Livewire\Component;

class Done extends Component
{
    #[Layout('components.layouts.base_layout')]

    public function render()
    {
        return view('livewire.user.quiz.done')->title('Quiz Done');
    }
}
