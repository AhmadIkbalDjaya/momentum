<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Option extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'question_id' => 'integer',
        'is_correct' => 'boolean',
    ];

    public function scopeIsCorrect($query)
    {
        return $query->where('is_correct', true);
    }

    public function scopeIsIncorrect($query)
    {
        return $query->where('is_correct', false);
    }

    public function question(): BelongsTo
    {
        return $this->belongsTo(Question::class);
    }

    public function question_answer(): HasOne
    {
        return $this->hasOne(Question::class, 'correct_answer_id');
    }

    public function student_quiz(): HasMany
    {
        return $this->hasMany(StudentQuiz::class);
    }
}
