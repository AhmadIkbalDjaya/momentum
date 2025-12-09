<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\StudentQuiz;

class QuizRecapController extends Controller
{
    public function print(Quiz $quiz)
    {
        $student_quizzes = StudentQuiz::where('quiz_id', $quiz->id)
            ->orderBy('score', 'desc')
            ->get();

        return view('admin.quiz-recap.print', [
            'quiz' => $quiz,
            'quiz_students' => $student_quizzes,
        ]);
    }
}
