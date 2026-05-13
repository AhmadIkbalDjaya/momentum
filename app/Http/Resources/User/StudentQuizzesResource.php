<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentQuizzesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'student_name' => $this->student->name,
            'quiz_name' => $this->quiz->name,
            'quiz_type' => $this->quiz->quiz_type->description,
            'work_date' => $this->start_time,
            'duration' => $this->duration,
            'question_count' => $this->quiz->questions->count(),
            'answer_count' => $this->answer_count,
            'show_score' => $this->quiz->show_score,
            'score' => $this->get_score(),
        ];
    }

    public function get_score()
    {
        if ($this->quiz->show_score) {
            return "$this->score / 100";
        }

        return '-- / --';
    }
}
