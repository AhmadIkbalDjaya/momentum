@props([
  "quiz" => null,
  "questions" => [],
])

<div class="basis-full rounded-lg bg-white p-6 shadow-sm md:basis-8/12">
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
                <label for="selected_options{{ $option->id }}" class="flex">
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
          <span x-show="!$wire.all_answered" class="text-xs text-red-400">
            Semua pertanyaan belum terjawab
          </span>
        </div>
      </template>
    @endif
  </div>
</div>
