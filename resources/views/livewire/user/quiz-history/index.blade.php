@php
  $breadcrumbs = [
    [
      "name" => "Quiz History",
      "route" => "",
    ],
  ];
@endphp

<div>
  <x-breadcrumb :items="$breadcrumbs" />

  @php
    $totalAnswered = collect($student_quizzes)->sum("answer_count");
    $totalQuestions = collect($student_quizzes)->sum("question_count");
  @endphp

  <div class="space-y-4">
    <div class="rounded-lg bg-white p-5 shadow-sm">
      <div
        class="flex flex-col gap-4 md:flex-row md:items-center md:justify-between"
      >
        <div class="flex items-start gap-3">
          <div
            class="bg-primary/10 text-primary grid h-12 w-12 shrink-0 place-items-center rounded-lg"
          >
            <x-icons.clock-rotate-left class="h-6 w-6" />
          </div>
          <div>
            <h1 class="text-primary text-xl font-bold">Riwayat Quiz</h1>
            <p class="mt-1 text-sm font-medium text-gray-500">
              Lihat kembali hasil quiz yang sudah kamu kerjakan.
            </p>
          </div>
        </div>

        <div class="grid grid-cols-2 gap-3 md:min-w-72">
          <div class="rounded-lg bg-gray-50 p-3">
            <p class="text-xs font-semibold text-gray-500">Quiz Selesai</p>
            <p class="text-primary mt-1 text-2xl font-bold">
              {{ count($student_quizzes) }}
            </p>
          </div>
          <div class="rounded-lg bg-gray-50 p-3">
            <p class="text-xs font-semibold text-gray-500">Soal Dijawab</p>
            <p class="text-primary mt-1 text-2xl font-bold">
              {{ $totalAnswered }}/{{ $totalQuestions }}
            </p>
          </div>
        </div>
      </div>
    </div>

    <div class="overflow-hidden rounded-lg bg-white shadow-sm">
      <div
        class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 px-4 py-4"
      >
        <div class="text-primary flex items-center gap-x-2">
          <x-icons.list class="h-5 w-5" />
          <h2 class="font-bold">Daftar Riwayat</h2>
        </div>
        @if (count($student_quizzes) > 0)
          <span
            class="bg-primary/10 text-primary rounded-full px-3 py-1 text-xs font-bold"
          >
            {{ count($student_quizzes) }} riwayat
          </span>
        @endif
      </div>

      @if (count($student_quizzes) > 0)
        <div>
          @foreach ($student_quizzes as $student_quiz)
            <livewire:user.components.quiz-history-row
              :student_quiz="$student_quiz"
              :compact="true"
            />
          @endforeach
        </div>
      @else
        <div class="grid min-h-56 place-items-center px-4 py-8">
          <div class="grid place-items-center text-center">
            <img
              src="{{ asset("images/icons/out-of-stock.webp") }}"
              class="h-20"
              alt="Empty Quiz History"
              srcset=""
            />
            <p class="mt-3 font-bold text-gray-500">
              Belum Ada Quiz Yang Dikerjakan
            </p>
            <p class="mt-1 text-sm font-medium text-gray-400">
              Riwayat pengerjaan akan muncul setelah kamu menyelesaikan quiz.
            </p>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
