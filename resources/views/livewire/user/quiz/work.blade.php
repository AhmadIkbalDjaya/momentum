@php
  $breadcrumbs = [
    [
      "name" => "Quiz",
      "route" => "quiz.index",
    ],
    [
      "name" => $quiz->name,
      "route" => "quiz.show",
      "params" => ["quiz" => $quiz->id],
    ],
    [
      "name" => "Kerjakan Quiz",
      "route" => "",
    ],
  ];
@endphp

<div>
  <x-breadcrumb :items="$breadcrumbs" />

  @if ($requires_code)
    <x-pages.quiz.code-form />
  @else
    <div x-data="question">
      <h1 class="text-primary relative px-3 text-xl font-semibold">
        {{ $quiz->name }}
        <span
          class="bg-primary absolute top-1/2 left-0 h-[80%] w-1 -translate-y-1/2 rounded-full"
        ></span>
      </h1>
      <div
        class="mt-5 flex flex-wrap items-start justify-between gap-x-5 gap-y-3 md:flex-nowrap"
      >
        @if (count($questions) > 0)
          <x-pages.quiz.question-panel
            :quiz="$quiz"
            :questions="$questions"
          />
        @else
          <livewire:user.quiz.components.empty-question />
        @endif

        {{-- question list box --}}
        <div class="basis-full md:basis-4/12">
          <div class="space-y-3">
            <x-pages.quiz.question-navigator
              :quiz="$quiz"
              :questions="$questions"
            />

            <x-pages.quiz.time-remaining />

            @if ($quiz->type === \App\Enums\QuizType::Essay)
              <x-pages.quiz.essay-upload />
            @endif
          </div>
        </div>
      </div>
    </div>
  @endif
</div>

@if (! $requires_code)
  @script
    <script>
      Alpine.data('question', () => ({
        active_question: 1,
        answeredCount() {
          return Object.values($wire.selected_options ?? {}).filter(
            (option) => option !== null && option !== '',
          ).length;
        },
        answeredPercent() {
          return $wire.question_count > 0
            ? (this.answeredCount() / $wire.question_count) * 100
            : 0;
        },
        setActiveQuestion(type = 'set', number = 1) {
          if (type == 'next' && this.active_question != $wire.question_count) {
            this.active_question++;
          } else if (type == 'previous' && this.active_question != 1) {
            this.active_question--;
          } else if (type == 'set') {
            this.active_question = number;
          }
        },
      }));
      Alpine.data('timeRemaining', () => ({
        quizEndTime: new Date(@json($quiz->end_time)),
        startTimeWork: new Date(@json($student_quiz->start_time)),
        duration: @json($quiz->duration) * 60,
        remainingTime: '00:00',
        remainingPercent: 100,
        timer: null,

        calculateRemainingTime() {
          const now = new Date();
          const timeToExpire = Math.floor((this.quizEndTime - now) / 1000);
          const elapsed = Math.floor((now - this.startTimeWork) / 1000);
          const remainingFromStart = this.duration - elapsed;
          const totalRemaining = Math.min(timeToExpire, remainingFromStart);

          if (totalRemaining <= 0) {
            $wire.dispatch('time-up');
            this.remainingTime = 'Waktu Habis';
            this.remainingPercent = 0;
            clearInterval(this.onlineEvent);
            clearInterval(this.timer);
            return;
          }

          this.remainingPercent =
            this.duration > 0
              ? Math.max(
                  0,
                  Math.min(100, (totalRemaining / this.duration) * 100),
                )
              : 0;

          const minutes = String(Math.floor(totalRemaining / 60)).padStart(
            2,
            '0',
          );
          const seconds = String(totalRemaining % 60).padStart(2, '0');
          this.remainingTime = `${minutes}:${seconds}`;
        },

        startTimer() {
          this.calculateRemainingTime();
          this.timer = setInterval(() => this.calculateRemainingTime(), 1000);
          this.onlineEvent = setInterval(
            () => $wire.sendOnlineEvent('online', this.remainingTime, 0),
            3000,
          );
        },

        stopTimer() {
          clearInterval(this.timer);
        },

        init() {
          this.startTimer();
        },
      }));
    </script>
  @endscript
@endif
