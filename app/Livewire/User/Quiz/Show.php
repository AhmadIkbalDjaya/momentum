<?php

namespace App\Livewire\User\Quiz;

use App\Models\Quiz;
use App\Models\StudentQuiz;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Validate;
use Livewire\Component;

class Show extends Component
{
    #[Layout('components.layouts.base_layout')]
    public Quiz $quiz;

    public $has_work;

    public $has_end;

    public $has_begin = false;

    public function mount()
    {
        $this->has_work = StudentQuiz::select('is_done')->where('quiz_id', $this->quiz->id)
            ->where('student_id', auth()->guard('student')->user()->id)
            ->pluck('is_done')->first();
        $current_time = Carbon::now();
        $end_time = Carbon::parse($this->quiz->end_time);
        if ($current_time->greaterThan($end_time)) {
            $this->has_end = true;
        }
        if (Carbon::now()->greaterThan(Carbon::parse($this->quiz->start_time))) {
            $this->has_begin = true;
        }
    }

    public function render()
    {
        return view('livewire.user.quiz.show', [
        ])->title($this->quiz->name);
    }

    // quiz validate
    #[Validate('required')]
    public $quiz_code;

    public function checkCode($quiz_code)
    {
        $this->quiz_code = $quiz_code;
        $this->validate();

        if ($this->quiz_code == $this->quiz->code) {
            return $this->redirectRoute('quiz.work', ['quiz' => $this->quiz->id], navigate: true);
        }
        $this->addError('quiz_code', 'Code Quiz Salah');
    }

    public function clearValidation($field = null)
    {
        $this->resetValidation($field ?? 'quiz_code');
    }
}
