<?php

namespace App\Livewire\User\Components;

use Livewire\Component;

class QuizHistoryRow extends Component
{
    public $student_quiz;

    public function mount($student_quiz)
    {
        $this->student_quiz = $student_quiz;
        $this->second_to_minute();
    }

    public function render()
    {
        return view('livewire.user.components.quiz-history-row');
    }

    public function second_to_minute()
    {
        $allsecond = $this->student_quiz['duration'];
        if ($allsecond < 0) {
            $this->dispatch('time-up');

            return 'Waktu Habis';
        }
        $minutes = floor($allsecond / 60);
        $seconds = $allsecond % 60;
        if ($minutes < 10) {
            $minutes = "0$minutes";
        }
        if ($seconds < 10) {
            $seconds = "0$seconds";
        }
        $this->student_quiz['duration'] = "$minutes:$seconds";
    }
}
