<?php

namespace Tests\Unit;

use App\Models\Quiz;
use Illuminate\Support\Carbon;
use Tests\TestCase;

class QuizStatusTest extends TestCase
{
    protected function tearDown(): void
    {
        Carbon::setTestNow();

        parent::tearDown();
    }

    public function test_status_is_inactive_when_quiz_is_not_active(): void
    {
        Carbon::setTestNow('2026-05-20 12:00:00');

        $quiz = $this->quiz([
            'is_active' => false,
            'start_time' => '2026-05-20 11:00:00',
            'end_time' => '2026-05-20 13:00:00',
        ]);

        $this->assertSame('inactive', $quiz->status);
    }

    public function test_status_is_upcoming_before_start_time(): void
    {
        Carbon::setTestNow('2026-05-20 12:00:00');

        $quiz = $this->quiz([
            'is_active' => true,
            'start_time' => '2026-05-20 13:00:00',
            'end_time' => '2026-05-20 14:00:00',
        ]);

        $this->assertSame('upcoming', $quiz->status);
    }

    public function test_status_is_ongoing_between_start_and_end_time(): void
    {
        Carbon::setTestNow('2026-05-20 12:00:00');

        $quiz = $this->quiz([
            'is_active' => true,
            'start_time' => '2026-05-20 11:00:00',
            'end_time' => '2026-05-20 13:00:00',
        ]);

        $this->assertSame('ongoing', $quiz->status);
    }

    public function test_status_is_ended_after_end_time(): void
    {
        Carbon::setTestNow('2026-05-20 12:00:00');

        $quiz = $this->quiz([
            'is_active' => true,
            'start_time' => '2026-05-20 10:00:00',
            'end_time' => '2026-05-20 11:00:00',
        ]);

        $this->assertSame('ended', $quiz->status);
    }

    private function quiz(array $attributes): Quiz
    {
        $quiz = new Quiz;
        $quiz->setRawAttributes($attributes, true);

        return $quiz;
    }
}
