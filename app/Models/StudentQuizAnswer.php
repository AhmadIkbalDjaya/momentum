<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class StudentQuizAnswer extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'student_quiz_id' => 'integer',
        'question_id' => 'integer',
        'option_id' => 'integer',
        'is_correct' => 'boolean',
    ];

    public function student_quiz(): BelongsTo
    {
        return $this->belongsTo(StudentQuiz::class);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }
}
