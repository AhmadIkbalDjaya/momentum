<?php

namespace App\Support;

use App\Models\Quiz;

class QuizWorkAccess
{
    public static function grant(Quiz $quiz, int $studentId): void
    {
        session()->put(self::key($quiz, $studentId), true);
    }

    public static function allows(Quiz $quiz, int $studentId): bool
    {
        return session()->has(self::key($quiz, $studentId));
    }

    public static function forget(Quiz $quiz, int $studentId): void
    {
        session()->forget(self::key($quiz, $studentId));
    }

    private static function key(Quiz $quiz, int $studentId): string
    {
        return "quiz_work_access.{$studentId}.{$quiz->id}";
    }
}
