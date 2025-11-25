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

  <div x-data="question">
    <h1 class="px-3 font-bold text-primary">{{ $quiz->name }}</h1>
    <div
      class="mt-5 flex flex-wrap justify-between gap-x-5 gap-y-3 md:flex-nowrap"
    >
      @if (count($questions) > 0)
        <div class="basis-full rounded-lg bg-white p-6 shadow-sm md:basis-8/12">
          <h6 class="text-base font-medium">
            Nomor
            <span x-text="active_question"></span>
          </h6>
          @foreach ($questions as $index => $question)
            <div
              x-cloak
              x-show="active_question == {{ $loop->iteration }}"
              class="block"
            >
              <div class="">
                {!! $question->question !!}
                <div class="clear-left block"></div>
              </div>
              @if ($quiz->quiz_type_id != 3)
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
                          <p class="me-2">
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
                          <div>
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
              class="rounded bg-primary px-3 py-1 text-white"
            >
              <i class="fa-solid fa-arrow-left"></i>
              Sebelumnya
            </button>

            <button
              x-cloak
              x-show="active_question != $wire.question_count"
              x-on:click="setActiveQuestion('next')"
              class="rounded bg-primary px-3 py-1 text-white"
            >
              Selanjutnya
              <i class="fa-solid fa-arrow-right"></i>
            </button>

            @if ($quiz->quiz_type_id != 3)
              <template x-if="active_question == $wire.question_count">
                <div class="">
                  <button
                    x-show="$wire.all_answered"
                    wire:click="submit_quiz"
                    class="flex items-center justify-center gap-x-1 rounded bg-primary px-3 py-1 text-white"
                  >
                    <x-loading-icon target="submit_quiz" />
                    Kumpulkan
                    <i class="fa-solid fa-arrow-right"></i>
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
        <div class="rounded-lg bg-white pb-5 shadow-sm">
          <h6 class="rounded-t-lg bg-gray-200 px-5 py-2 font-medium">
            Daftar Soal
          </h6>
          <div class="px-6 py-6">
            <div class="grid grid-cols-5 justify-between gap-2">
              @foreach ($questions as $index => $question)
                <button
                  x-on:click="setActiveQuestion('set', {{ $loop->iteration }})"
                  x-bind:class="
                    active_question == {{ $loop->iteration }}
                      ? 'bg-primary'
                      : $wire.selected_options[{{ $index }}] != null
                        ? 'bg-secondary'
                        : 'bg-gray-500'
                  "
                  class="rounded px-2 py-1 font-medium text-white"
                >
                  {{ $loop->iteration }}
                </button>
              @endforeach
            </div>
          </div>
          <div x-data="timeRemaining" class="flex gap-2 px-6 text-sm">
            <p class="text-gray-500">Waktu Tersisa:</p>
            <p class="font-medium" x-text="remainingTime"></p>
          </div>
          <div class="mt-2 flex gap-x-2 px-6">
            <div class="flex items-center gap-x-1">
              <div class="h-3 w-3 rounded bg-primary"></div>
              <p class="text-xs">Dilihat</p>
            </div>
            @if ($quiz->quiz_type_id != 3)
              <div class="flex items-center gap-x-1">
                <div class="h-3 w-3 rounded bg-secondary"></div>
                <p class="text-xs">Terjawab</p>
              </div>
              <div class="flex items-center gap-x-1">
                <div class="h-3 w-3 rounded bg-gray-500"></div>
                <p class="text-xs">Belum Dijawab</p>
              </div>
            @endif
          </div>
          @if ($quiz->quiz_type_id == 3)
            <div class="mt-3 px-6">
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
                  class="block w-full cursor-pointer rounded-lg border border-gray-300 bg-gray-50 text-sm text-gray-900 focus:outline-none"
                  id=""
                  accept=".pdf"
                />
                @error("essay_answer_file")
                  <livewire:components.input-error-message
                    field="essay_answer_file"
                  />
                @enderror

                <button
                  type="submit"
                  class="mt-2 w-full rounded bg-primary px-5 py-1 text-white"
                >
                  Kumpul dan Selesaikan
                </button>
              </form>
            </div>
          @endif
        </div>
      </div>
    </div>
  </div>
</div>

@script
  <script>
    Alpine.data('question', () => ({
      active_question: 1,
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
          clearInterval(this.onlineEvent);
          clearInterval(this.timer);
          return;
        }

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
