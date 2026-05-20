<?php

namespace App\Models;

use App\Enums\Gender;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class Student extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
    ];

    protected $casts = [
        'password' => 'hashed',
        'gender' => Gender::class,
        'school_id' => 'integer',
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function student_quiz(): HasMany
    {
        return $this->hasMany(StudentQuiz::class);
    }

    public function quizzes(): BelongsToMany
    {
        return $this->belongsToMany(Quiz::class, 'student_quizzes', 'student_id', 'quiz_id')->withPivot('is_done', 'score');
    }

    /**
     * Get all of the student_quiz_answers for the Student
     */
    public function student_quiz_answers(): HasManyThrough
    {
        return $this->hasManyThrough(
            StudentQuizAnswer::class,
            StudentQuiz::class,
            'student_id',        // Foreign key on the student_quizzes table
            'student_quiz_id',   // Foreign key on the student_quiz_answers table
            'id',                // Local key on the students table
            'id'                 // Local key on the student_quizzes table
        );
    }
}
