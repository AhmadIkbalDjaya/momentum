<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UserOnline implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $quiz_id;

    public $student_id;

    public $status;

    public $answer_count;

    public $time_remaining;

    public $is_done = false;

    /**
     * Create a new event instance.
     */
    public function __construct($quizId, $studentId, $status, $answerCount, $timeRemaining, $is_done)
    {
        $this->quiz_id = $quizId;
        $this->student_id = $studentId;
        $this->status = $status;
        $this->answer_count = $answerCount;
        $this->time_remaining = $timeRemaining;
        $this->is_done = $is_done;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('quiz.'.$this->quiz_id),
        ];
    }
}
