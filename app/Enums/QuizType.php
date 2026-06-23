<?php

namespace App\Enums;

enum QuizType: string
{
    case MultipleChoice = 'mc';
    case TrueFalse = 'tf';
    case Essay = 'essay';

    public function label(): string
    {
        return match ($this) {
            self::MultipleChoice => 'Pilihan Ganda',
            self::TrueFalse => 'Benar Salah',
            self::Essay => 'Essay',
        };
    }
}
