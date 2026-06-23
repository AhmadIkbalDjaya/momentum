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
    <div class="mx-auto max-w-md rounded-lg bg-white p-6 shadow-sm">
      <form wire:submit="checkCode">
        <div class="mb-5 text-center">
          <div
            class="text-primary bg-primary/10 mx-auto mb-4 grid h-12 w-12 place-items-center rounded-md"
          >
            <x-icons.lock class="h-5 w-5" />
          </div>
          <h1 class="text-primary text-xl font-bold">Masukkan Kode Quiz</h1>
          <p class="mt-2 text-sm font-medium text-gray-500">
            Gunakan kode yang diberikan untuk mulai mengerjakan quiz.
          </p>
        </div>

        <div>
          <label class="mb-2 block text-sm font-bold text-gray-700">
            Kode Quiz
          </label>
          <input
            wire:model="quiz_code"
            wire:input="clearValidation('quiz_code')"
            type="text"
            class="focus:outline-primary block w-full rounded-md border border-gray-300 bg-gray-50 p-3 text-center text-lg font-bold tracking-wide text-gray-900 uppercase"
            placeholder="Kode Quiz"
          />
          <div class="px-1">
            <x-input-error-message name="quiz_code" />
          </div>
        </div>

        <button
          type="submit"
          class="btn btn-primary mt-5 w-full rounded-md px-4 py-2.5 text-sm"
        >
          <x-loading-icon target="checkCode" />
          Mulai
        </button>
      </form>
    </div>
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
          <div
            class="basis-full rounded-lg bg-white p-6 shadow-sm md:basis-8/12"
          >
            <div class="mb-2.5 flex justify-between">
              <h6 class="text-sm font-medium text-gray-500 select-none">
                Soal
                <span x-text="active_question"></span>
                dari {{ count($questions) }}
              </h6>
              @if ($quiz->type !== \App\Enums\QuizType::Essay)
                <span
                  x-bind:class="
                    $wire.selected_options[active_question - 1] != null
                      ? 'bg-green-700'
                      : 'bg-gray-500'
                  "
                  class="inline-block rounded px-3 py-1 text-xs font-medium text-white select-none"
                  x-text="
                    $wire.selected_options[active_question - 1] != null
                      ? 'Terjawab'
                      : 'Belum Dijawab'
                  "
                ></span>
              @endif
            </div>
            @foreach ($questions as $index => $question)
              <div
                x-cloak
                x-show="active_question == {{ $loop->iteration }}"
                class="block"
              >
                <div class="select-none">
                  {!! $question->question !!}
                  <div class="clear-left block"></div>
                </div>
                @if ($quiz->type !== \App\Enums\QuizType::Essay)
                  <div class="my-2 box-border block w-full">
                    <form action="">
                      @foreach ($question->options as $option)
                        <div class="flex items-start gap-1 py-3">
                          <input
                            type="radio"
                            wire:model="selected_options.{{ $index }}"
                            wire:click="updateAnswer"
                            name="question{{ $question->id }}options"
                            value="{{ $option->id }}"
                            id="selected_options{{ $option->id }}"
                            class="mt-2"
                          />
                          <label
                            for="selected_options{{ $option->id }}"
                            class="flex"
                          >
                            <p class="me-2 select-none">
                              @if ($loop->iteration == 1)
                                A.
                              @elseif ($loop->iteration == 2)
                                B.
                              @elseif ($loop->iteration == 3)
                                C.
                              @elseif ($loop->iteration == 4)
                                D.
                              @elseif ($loop->iteration == 5)
                                E.
                              @endif
                            </p>
                            <div class="select-none">
                              {!! $option->option !!}
                            </div>
                          </label>
                        </div>
                      @endforeach
                    </form>
                  </div>
                  <div class="clear-left block"></div>
                @endif
              </div>
            @endforeach

            {{-- next prev question --}}
            <div
              x-bind:class="active_question > 1 ? 'justify-between' : 'justify-end'"
              class="mt-10 flex w-full"
            >
              <button
                x-cloak
                x-show="active_question > 1"
                x-on:click="setActiveQuestion('previous')"
                class="btn border-primary text-primary rounded border px-3 py-1"
              >
                <x-icons.angle-left class="h-5 w-5" />
                Sebelumnya
              </button>

              <button
                x-cloak
                x-show="active_question != $wire.question_count"
                x-on:click="setActiveQuestion('next')"
                class="btn btn-primary rounded px-3 py-1"
              >
                Selanjutnya
                <x-icons.angle-right class="h-5 w-5" />
              </button>

              @if ($quiz->type !== \App\Enums\QuizType::Essay)
                <template x-if="active_question == $wire.question_count">
                  <div class="">
                    <button
                      x-show="$wire.all_answered"
                      wire:click="submit_quiz"
                      class="btn btn-primary rounded px-3 py-1"
                    >
                      <x-loading-icon target="submit_quiz" />
                      Kumpulkan
                      <x-icons.floppy-disk class="h-5 w-5" />
                    </button>
                    <span
                      x-show="!$wire.all_answered"
                      class="text-xs text-red-400"
                    >
                      Semua pertanyaan belum terjawab
                    </span>
                  </div>
                </template>
              @endif
            </div>
          </div>
        @else
          <livewire:user.quiz.components.empty-question />
        @endif

        {{-- question list box --}}
        <div class="basis-full md:basis-4/12">
          <div class="space-y-3">
            <div class="rounded-lg bg-white p-6 shadow-sm">
              <h6 class="mb-5 font-semibold text-gray-700">Daftar Soal</h6>
              <div class="grid grid-cols-5 gap-3">
                @foreach ($questions as $index => $question)
                  <button
                    x-on:click="setActiveQuestion('set', {{ $loop->iteration }})"
                    x-bind:class="
                      active_question == {{ $loop->iteration }}
                        ? 'border-primary text-primary bg-white'
                        : $wire.selected_options[{{ $index }}] != null
                          ? 'border-green-500 bg-green-50 text-green-700'
                          : 'border-gray-200 bg-white text-gray-700'
                    "
                    class="hover:border-primary hover:text-primary flex aspect-square items-center justify-center rounded-md border text-sm font-semibold shadow-sm transition"
                  >
                    {{ $loop->iteration }}
                  </button>
                @endforeach
              </div>

              <div
                class="mt-5 flex flex-wrap gap-x-4 gap-y-3 text-xs text-gray-600"
              >
                <div class="flex items-center gap-x-2">
                  <div
                    class="border-primary h-3 w-3 rounded-full border-2"
                  ></div>
                  <p>Sedang Dikerjakan</p>
                </div>
                @if ($quiz->type !== \App\Enums\QuizType::Essay)
                  <div class="flex items-center gap-x-2">
                    <div class="h-3 w-3 rounded-full bg-green-700"></div>
                    <p>Terjawab</p>
                  </div>
                  <div class="flex items-center gap-x-2">
                    <div
                      class="h-3 w-3 rounded-full border border-gray-300"
                    ></div>
                    <p>Belum Dijawab</p>
                  </div>
                @endif
              </div>

              @if ($quiz->type !== \App\Enums\QuizType::Essay)
                <div class="mt-6 border-t border-gray-200 pt-4">
                  <p class="text-sm text-gray-500">
                    <span
                      class="font-semibold text-gray-700"
                      x-text="answeredCount()"
                    ></span>
                    /
                    <span>{{ count($questions) }}</span>
                    terjawab
                  </p>
                  <div
                    class="mt-3 h-2 overflow-hidden rounded-full bg-gray-200"
                  >
                    <div
                      class="h-full rounded-full bg-green-700 transition-all"
                      x-bind:style="`width: ${answeredPercent()}%`"
                    ></div>
                  </div>
                </div>
              @endif
            </div>

            <div
              x-data="timeRemaining"
              class="rounded-lg bg-white p-6 shadow-sm"
            >
              <h6 class="mb-3 font-semibold text-gray-700">Waktu Tersisa</h6>
              <div class="flex items-center gap-5">
                <x-icons.clock-hour-4 class="text-primary h-10 w-10" />
                <p
                  x-bind:class="remainingTime == 'Waktu Habis' ? 'text-2xl' : 'text-5xl'"
                  class="text-primary font-bold"
                  x-text="remainingTime"
                ></p>
              </div>
              <div class="bg-primary/15 mt-5 h-2 overflow-hidden rounded-full">
                <div
                  class="bg-primary h-full rounded-full transition-all"
                  x-bind:style="`width: ${remainingPercent}%`"
                ></div>
              </div>
            </div>

            @if ($quiz->type === \App\Enums\QuizType::Essay)
              <div class="rounded-lg bg-white p-6 shadow-sm">
                <form
                  action=""
                  wire:submit="submit_essay_quiz"
                  enctype="multipart/form-data"
                >
                  <label
                    class="mb-2 block text-sm font-medium text-gray-900"
                    for="file_input"
                  >
                    Upload Jawaban Anda (pdf)
                  </label>
                  <input
                    type="file"
                    wire:model="essay_answer_file"
                    name="essay_answer_file"
                    class="block w-full cursor-pointer rounded border border-gray-300 bg-gray-50 px-2 py-1 text-sm text-gray-900 focus:outline-none"
                    id=""
                    accept=".pdf"
                  />
                  <x-input-error-message name="essay_answer_file" />

                  <button
                    type="submit"
                    class="btn btn-primary mt-2 w-full rounded px-5 py-1"
                  >
                    <x-icons.floppy-disk class="h-5 w-5" />
                    Kumpul dan Selesaikan
                  </button>
                </form>
              </div>
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
