<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class QuizSubmission extends Model
{
    use HasFactory;
    protected $guarded = ["id"];
    public function student_quiz(): BelongsTo
    {
        return $this->belongsTo(StudentQuiz::class);
    }
}
