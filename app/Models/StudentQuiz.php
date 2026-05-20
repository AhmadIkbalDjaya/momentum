<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class StudentQuiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'student_id' => 'integer',
        'quiz_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'integer',
        'is_done' => 'boolean',
        'score' => 'integer',
    ];

    public function scopeIsDone($query)
    {
        return $query->where('is_done', true);
    }

    public function scopeNotDone($query)
    {
        return $query->where('is_done', false);
    }

    public function student(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    public function quiz(): BelongsTo
    {
        return $this->belongsTo(Quiz::class);
    }

    public function student_quiz(): HasMany
    {
        return $this->hasMany(StudentQuiz::class);
    }

    public function quiz_submission(): HasOne
    {
        return $this->hasOne(QuizSubmission::class);
    }

    public function student_quiz_answers(): HasMany
    {
        return $this->hasMany(StudentQuizAnswer::class);
    }
}
