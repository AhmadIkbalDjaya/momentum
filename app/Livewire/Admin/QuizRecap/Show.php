<?php

namespace App\Livewire\Admin\QuizRecap;

use App\Models\Quiz;
use App\Models\School;
use App\Models\StudentQuiz;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Infolists\Components\Grid;
use Filament\Infolists\Components\Group;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Concerns\InteractsWithInfolists;
use Filament\Infolists\Contracts\HasInfolists;
use Filament\Infolists\Infolist;
use Livewire\Component;

class Show extends Component implements HasForms, HasInfolists
{
    use InteractsWithInfolists;
    use InteractsWithForms;
    public Quiz $quiz;
    public $open_detail_modal = false;
    public StudentQuiz $activeStudentQuiz;
    public $activeRanking;
    public $correct_answer_count;
    public $wrong_answer_count;
    public $not_answer_count;
    public $score;
    public $duration;
    public $essay_file;

    public function render()
    {
        $student_quizzes = StudentQuiz::where("quiz_id", $this->quiz->id)->orderBy("score", "desc")->get();
        return view('livewire.admin.quiz-recap.show', [
            "student_quizzes" => $student_quizzes,
        ]);
    }

    public function openModal(StudentQuiz $studentQuiz, $ranking)
    {
        $this->activeStudentQuiz = $studentQuiz;
        $this->activeRanking = $ranking;
        $this->correct_answer_count = $studentQuiz->student_quiz_answers->where("is_correct", 1)->count();
        $this->wrong_answer_count = $studentQuiz->student_quiz_answers->where("is_correct", 0)->count();
        $this->not_answer_count = $studentQuiz->quiz->questions->count() - $studentQuiz->student_quiz_answers->count();
        $this->score = $studentQuiz->score;
        if ($studentQuiz->quiz->quiz_type_id == 3) {
            $this->essay_file = $studentQuiz->quiz_submission->file;
        }
        $this->duration = $this->convertSecondToHourMinuteSecond($studentQuiz->duration);
        $this->open_detail_modal = true;
    }
    public function closeModal()
    {
        $this->open_detail_modal = false;
    }

    public function setScore()
    {
        $this->activeStudentQuiz->update([
            "score" => $this->score,
        ]);
    }

    public function handleClickOpenFilter()
    {
        $this->openDropdown = !$this->openDropdown;
    }

    private function convertSecondToHourMinuteSecond($seconds): string
    {
        // Hitung jam, menit, dan detik
        $hours = floor($seconds / 3600); // 1 jam = 3600 detik
        $minutes = floor(($seconds % 3600) / 60); // Sisa detik setelah diambil jam, lalu dibagi 60
        $remainingSeconds = $seconds % 60; // Sisa detik setelah diambil jam dan menit

        // Format menjadi "jam:menit:detik"
        return sprintf("%02d:%02d:%02d", $hours, $minutes, $remainingSeconds);
    }
}
