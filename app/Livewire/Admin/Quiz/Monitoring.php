<?php

namespace App\Livewire\Admin\Quiz;

use App\Models\Quiz;
use App\Models\Student;
use App\Models\StudentQuizAnswer;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\On;
use Livewire\Component;

class Monitoring extends Component
{
    public Quiz $quiz;

    public $students = [];

    #[On('echo:quiz.{quiz.id},UserOnline')]
    public function refreshData($event)
    {
        foreach ($this->students as $index => $student) {
            if ($student['id'] == $event['student_id']) {
                $this->students[$index]['status'] = $event['status'];
                $this->students[$index]['time_remaining'] = $event['time_remaining'];
                $this->students[$index]['answer_count'] = $event['answer_count'];
                $this->students[$index]['is_done'] = $event['is_done'];
                $this->students[$index]['last_event_time'] = Carbon::now();
            }
        }
    }

    public function mount()
    {
        $students = Student::select(
            'students.*',
            'student_quizzes.is_done',
            DB::raw('COALESCE(student_quiz_answers.answer_count, 0) as answer_count'),
        )
            ->whereHas('school', function ($query) {
                $query->where('school_category_id', $this->quiz->school_category_id);
            })
            ->leftJoin('student_quizzes', function ($join) {
                return $join->on('students.id', '=', 'student_quizzes.student_id')
                    ->where('student_quizzes.quiz_id', $this->quiz->id);
            })
            ->leftJoinSub(
                StudentQuizAnswer::select('student_quizzes.student_id', \DB::raw('COUNT(student_quiz_answers.id) as answer_count'))
                    ->join('student_quizzes', 'student_quizzes.id', '=', 'student_quiz_answers.student_quiz_id')
                    ->where('student_quizzes.quiz_id', $this->quiz->id)
                    ->groupBy('student_quizzes.student_id'),
                'student_quiz_answers',
                'student_quiz_answers.student_id',
                '=',
                'students.id'
            )
            ->get();

        $this->students = $students->map(function ($student) {
            return [
                'id' => $student->id,
                'name' => $student->name,
                'status' => 'offline',
                'time_remaining' => '-',
                'answer_count' => $student->answer_count,
                'is_done' => $student->is_done,
                'school_name' => $student->school->name,
                'last_event_time' => null,
            ];
        })->toArray();
    }

    public function render()
    {
        return view('livewire.admin.quiz.monitoring');
    }

    public function check_expire()
    {
        foreach ($this->students as $index => $student) {
            if ($student['last_event_time'] != null) {
                if ($student['last_event_time']->diffInSeconds(Carbon::now()) > 3) {
                    $this->students[$index]['status'] = 'offline';
                    $this->students[$index]['time_remaining'] = '-';
                    $this->students[$index]['last_event_time'] = null;
                }
            }
        }
    }
}
