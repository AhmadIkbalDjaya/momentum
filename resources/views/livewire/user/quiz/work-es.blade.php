{{-- <div wire:poll.10s="save_answer"> --}}
<div>
  <nav
    class="w-full rounded-md bg-gray-100 px-3 pb-3 pt-0 font-normal text-gray-500"
  >
    <ol class="list-reset flex">
      <li>
        <a
          wire:navigate
          href="{{ route("home") }}"
          class="text-nowrap text-gray-500"
        >
          Home
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a
          wire:navigate
          href="{{ route("quiz.index") }}"
          class="text-nowrap text-gray-500"
        >
          Quiz
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a
          wire:navigate
          href="{{ route("quiz.show", ["quiz" => $quiz->id]) }}"
          class="text-nowrap text-gray-500"
        >
          {{ $quiz->name }}
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a class="text-nowrap text-gray-500">Kerjakan Quiz</a>
      </li>
    </ol>
  </nav>

  <div class="">
    <h1 class="px-3 font-bold text-primary">{{ $quiz->name }}</h1>
    <div
      class="mt-5 flex flex-wrap justify-between gap-x-5 gap-y-3 md:flex-nowrap"
    >
      <div
        class="h-full basis-full rounded-lg bg-white p-6 shadow-sm md:basis-8/12"
      >
        <div class="flex flex-col justify-between">
          <div>
            <h6 class="text-base font-medium">Nomor {{ $active_question }}</h6>
            @foreach ($quiz->questions as $index => $question)
              @if ($loop->iteration == $active_question)
                <div>
                  <div>
                    {!! $question->question !!}
                  </div>
                </div>
              @endif
            @endforeach
          </div>
          <div
            class="{{ $active_question > 1 ? "justify-between" : "justify-end" }} mt-10 flex"
          >
            @if ($active_question > 1)
              <button
                wire:click="previousQuestion"
                class="rounded bg-primary px-3 py-1 text-white"
              >
                <i class="fa-solid fa-arrow-left"></i>
                Sebelumnya
              </button>
            @endif

            @if ($active_question != $quiz->questions->count())
              <button
                wire:click="nextQuestion"
                class="rounded bg-primary px-3 py-1 text-white"
              >
                Selanjutnya
                <i class="fa-solid fa-arrow-right"></i>
              </button>
            @endif

            {{--
              @if ($active_question == $quiz->questions->count())
              @if ($all_answered == true)
              <button wire:click='submit_quiz' class="px-3 py-1 rounded bg-primary text-white">
              Kumpulkan
              <i class="fa-solid fa-arrow-right"></i>
              </button>
              @elseif ($all_answered == false)
              <span class="text-xs text-red-400">
              Semua pertanyaan belum terjawab
              </span>
              @endif
              @endif
            --}}
          </div>
        </div>
      </div>
      <div class="basis-full md:basis-4/12">
        <div class="rounded-lg bg-white pb-5 shadow-sm">
          <h6 class="rounded-t-lg bg-gray-200 px-5 py-2 font-medium">
            Daftar Soal
          </h6>
          <div class="px-6 py-6">
            <div class="grid grid-cols-5 justify-between gap-2">
              @foreach ($quiz->questions as $index => $question)
                <button
                  wire:click="setQuestion({{ $loop->iteration }})"
                  class="{{ $loop->iteration == $active_question ? "bg-primary" : ($selected_options[$index] != null ? "bg-secondary" : "bg-gray-500") }} rounded px-2 py-1 font-medium text-white"
                >
                  {{ $loop->iteration }}
                </button>
              @endforeach
            </div>
          </div>
          <div class="flex items-center justify-between gap-x-2">
            <livewire:user.components.time-remaining
              :quiz_end_time="$quiz->end_time"
              :start_time_work="$student_quiz->start_time"
              :duration="$quiz->duration"
            />
            <div class="flex gap-x-2 px-6">
              <div class="flex items-center gap-x-1">
                <div class="h-3 w-3 rounded bg-primary"></div>
                <p class="text-xs">Dilihat</p>
              </div>
            </div>
          </div>
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
        </div>
      </div>
    </div>
  </div>
</div>
