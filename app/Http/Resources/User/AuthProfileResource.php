<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AuthProfileResource extends JsonResource
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
            'name' => $this->name,
            'username' => $this->username,
            'gender' => $this->gender->getLabel(),
            'school' => $this->school->name,
            'quiz_count' => $this->quiz_count,
            'answer_count' => $this->answers_count,
        ];
    }
}
