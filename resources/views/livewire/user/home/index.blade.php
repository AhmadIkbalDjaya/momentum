<div class="flex flex-col gap-y-5">
  <div class="rounded-lg bg-white p-6 shadow-sm">
    <div class="flex gap-x-2 md:gap-x-6">
      <img
        src="{{ asset("images/man2.webp") }}"
        alt="{{ $auth["name"] }}"
        srcset=""
        class="bg-primary h-20 rounded-lg md:h-36"
      />
      <div class="flex flex-col justify-around md:py-0">
        <div class="">
          <h6 class="text-primary text-xl font-medium">
            {{ $auth["name"] }}
          </h6>
          <p class="text-xs font-medium text-gray-400">
            {{ $auth["school"] }}
          </p>
        </div>
        <div class="flex flex-col gap-x-2 md:flex-row md:gap-x-8">
          <div class="flex gap-3">
            <div
              class="hidden place-items-center rounded px-3 py-2 shadow md:block"
            >
              <i class="fa-solid fa-flag text-primary text-lg"></i>
            </div>
            <div class="flex items-center gap-x-1 md:flex-col md:items-start">
              <h6 class="text-xs font-bold text-gray-400 md:text-lg">
                {{ $auth["quiz_count"] }}
              </h6>
              <p class="text-xs text-gray-400">Quiz Diselesaikan</p>
            </div>
          </div>
          <div class="flex gap-3">
            <div
              class="hidden place-items-center rounded px-3 py-2 shadow md:block"
            >
              <i class="fa-solid fa-circle-check text-primary text-lg"></i>
            </div>
            <div class="flex items-center gap-x-1 md:flex-col md:items-start">
              <h6 class="text-xs font-bold text-gray-400 md:text-lg">
                {{ $auth["answer_count"] }}
              </h6>
              <p class="text-xs text-gray-400">Soal Dijawab</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <div class="rounded-lg bg-white p-6 shadow-sm">
    <h1 class="text-primary font-bold">Quiz Tersedia</h1>
    @if (count($quizzes) > 0)
      <div class="grid grid-cols-1 justify-between gap-2 py-3 md:grid-cols-3">
        @foreach ($quizzes as $quiz)
          <livewire:user.components.quiz-card :quiz="$quiz" />
        @endforeach
      </div>
      <a
        wire:navigate
        href="{{ route("quiz.index") }}"
        class="text-primary block text-end font-medium"
      >
        Lihat Lainnya
      </a>
    @else
      <div class="grid grid-cols-1 place-items-center gap-2 py-5">
        <div class="grid place-items-center">
          <img
            src="{{ asset("images/icons/out-of-stock.webp") }}"
            class="h-16"
            alt="Empty Quiz"
            srcset=""
          />
          <p class="mt-2 font-medium text-gray-400">
            Belum Ada Quiz Yang Tersedia
          </p>
        </div>
      </div>
    @endif
  </div>

  <div class="rounded-lg bg-white p-6 shadow-sm">
    <h1 class="text-primary font-bold">History Quiz</h1>
    @if (count($student_quizzes) > 0)
      <div class="mt-5">
        @foreach ($student_quizzes as $student_quiz)
          <livewire:user.components.quiz-history-row
            :student_quiz="$student_quiz"
          />
        @endforeach
      </div>
      <a
        wire:navigate
        href="{{ route("quiz.index") }}"
        class="text-primary block text-end font-medium"
      >
        Lihat Lainnya
      </a>
    @else
      <div class="grid grid-cols-1 place-items-center gap-2 py-5">
        <div class="grid place-items-center">
          <img
            src="{{ asset("images/icons/out-of-stock.webp") }}"
            class="h-16"
            alt="Empty Quiz"
            srcset=""
          />
          <p class="mt-2 font-medium text-gray-400">
            Belum Ada Quiz Yang Dikerjakan
          </p>
        </div>
      </div>
    @endif
  </div>
</div>
