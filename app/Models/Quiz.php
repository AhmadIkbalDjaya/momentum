<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    public function school_category(): BelongsTo
    {
        return $this->belongsTo(SchoolCategory::class, 'school_category_id');
    }

    public function quiz_type(): BelongsTo
    {
        return $this->belongsTo(QuizType::class);
    }

    public function questions(): HasMany
    {
        return $this->hasMany(Question::class);
    }

    public function student_quiz(): HasMany
    {
        return $this->hasMany(StudentQuiz::class);
    }

    public function students(): BelongsToMany
    {
        return $this->belongsToMany(Student::class, 'student_quizzes', 'quiz_id', 'student_id')->withPivot('is_done', 'score');
    }
}
