<?php

namespace App\Livewire\User\Quiz;

use App\Events\UserOnline;
use App\Models\Question;
use App\Models\Quiz;
use App\Models\QuizSubmission;
use App\Models\StudentQuiz;
use App\Models\StudentQuizAnswer;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithFileUploads;

class Work extends Component
{
    use WithFileUploads;

    #[Layout('components.layouts.base_layout')]

    public Quiz $quiz;
    public StudentQuiz $student_quiz;
    public $questions = [];
    public $question_count = 0;
    public $selected_options = [];
    public $all_answered = false;
    public $answered_count;
    public $essay_answer_file;

    #[On('time-up')]
    public function on_time_up()
    {
        $this->submit_quiz();
    }

    public function mount()
    {
        $this->questions = Question::where('quiz_id', $this->quiz->id)
            ->with([
                'options',
            ])->get();
        $this->question_count = $this->questions->count();

        // get or create student quiz data
        $this->student_quiz = StudentQuiz::with([
            'student_quiz_answers',
        ])
            ->firstOrCreate(
                [
                    'student_id' => auth()->guard('student')->user()->id,
                    'quiz_id' => $this->quiz->id
                ],
                ['start_time' => Carbon::now()],
            );
        // check quiz has done or no
        if ($this->student_quiz->is_done) {
            return $this->redirectRoute('quiz.done', navigate: true);
        }

        // load saved answer from db
        $existingAnswers = $this->student_quiz->student_quiz_answers
            ->keyBy('question_id');

        $this->selected_options = $this->questions->mapWithKeys(function ($question, $index) use ($existingAnswers) {
            return [$index => $existingAnswers[$question->id]->option_id ?? null];
        })->toArray();

        $this->check_complete_answer();
    }

    public function render()
    {
        return view('livewire.user.quiz.work')->title('Quiz Work');
    }

    public function updateAnswer()
    {
        $this->check_complete_answer();
        $this->save_answer();
    }

    public function save_answer()
    {
        $upsert = $this->quiz->questions
            ->filter(fn($question, $index) => $this->selected_options[$index] !== null)
            ->map(function ($question, $index) {
                return [
                    'student_quiz_id' => $this->student_quiz->id,
                    'question_id' => $question->id,
                    'option_id' => $this->selected_options[$index],
                    'is_correct' => $this->selected_options[$index] == $question->correct_answer_id,
                ];
            })->values()->toArray();

        if (!empty($upsert)) {
            StudentQuizAnswer::upsert(
                $upsert,
                ['student_quiz_id', 'question_id'],
                ['option_id', 'is_correct']
            );
        }
    }

    public function check_complete_answer()
    {
        $this->answered_count = collect($this->selected_options)
            ->filter()
            ->count();

        $this->all_answered = $this->answered_count == count($this->selected_options);
    }

    public function submit_quiz()
    {
        $this->save_answer();
        $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $this->student_quiz->start_time);
        $end_time = Carbon::now();
        $duration = $start_time->diffInSeconds($end_time, false);
        // count score
        $correct_count = $this->student_quiz->student_quiz_answers->where('is_correct', true)->count();
        $total_questions = $this->quiz->questions->count();
        $score = $total_questions > 0 ? (($correct_count / $total_questions) * 100) : 0;

        $this->student_quiz->update([
            'is_done' => true,
            'end_time' => $end_time,
            'duration' => $duration,
            'score' => $score,
        ]);
        $this->sendOnlineEvent(
            'offline',
            '-',
            1,
        );

        return $this->redirectRoute('quiz.done', navigate: true);
    }

    public function submit_essay_quiz()
    {
        $validated = Validator::make(
            ['essay_answer_file' => $this->essay_answer_file],
            ['essay_answer_file' => 'required|mimes:pdf'],
        )->validate();

        if ($this->essay_answer_file) {
            $validated['essay_answer_file'] = $this->essay_answer_file->storePublicly('essay_answers');
        }

        DB::transaction(function () use ($validated) {
            $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $this->student_quiz->start_time);
            $end_time = Carbon::now();
            $duration = $start_time->diffInSeconds($end_time, false);
            $this->student_quiz->update([
                'is_done' => true,
                'end_time' => $end_time,
                'duration' => $duration,
            ]);
            QuizSubmission::create([
                'student_quiz_id' => $this->student_quiz->id,
                'file' => $validated['essay_answer_file'],
            ]);
        });

        return $this->redirectRoute('quiz.done', navigate: true);
    }

    public function sendOnlineEvent($status, $time_remaining, $is_done): void
    {
        UserOnline::dispatch(
            $this->quiz->id,
            auth('student')->user()->id,
            $status,
            $this->answered_count,
            $time_remaining,
            $is_done,
        );
    }
}
