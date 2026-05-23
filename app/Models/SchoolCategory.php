<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SchoolCategory extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected static function booted(): void
    {
        static::deleting(fn (self $schoolCategory): bool => ! $schoolCategory->isUsed());
    }

    public function schools(): HasMany
    {
        return $this->hasMany(School::class);
    }

    public function quizzes(): HasMany
    {
        return $this->hasMany(Quiz::class);
    }

    public function users(): HasMany
    {
        return $this->hasMany(User::class);
    }

    /**
     * @return array{schools: int, quizzes: int, users: int}
     */
    public function usageCounts(): array
    {
        return [
            'schools' => $this->schools()->count(),
            'quizzes' => $this->quizzes()->count(),
            'users' => $this->users()->count(),
        ];
    }

    public function isUsed(): bool
    {
        return $this->schools()->exists()
            || $this->quizzes()->exists()
            || $this->users()->exists();
    }
}
