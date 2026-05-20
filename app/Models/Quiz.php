<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Quiz extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $casts = [
        'school_category_id' => 'integer',
        'quiz_type_id' => 'integer',
        'start_time' => 'datetime',
        'end_time' => 'datetime',
        'duration' => 'integer',
        'is_active' => 'boolean',
        'show_score' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeBySchoolCategory($query, $schoolCategoryId)
    {
        return $query->where('school_category_id', $schoolCategoryId);
    }

    protected function status(): Attribute
    {
        return Attribute::make(
            get: function (): string {
                if (! $this->is_active) {
                    return 'inactive';
                }

                $currentTime = now();

                if ($currentTime->lessThan($this->start_time)) {
                    return 'upcoming';
                }

                if ($currentTime->between($this->start_time, $this->end_time)) {
                    return 'ongoing';
                }

                return 'ended';
            },
        );
    }

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
