@props([
  "student_quizzes" => [],
])

@php
  $totalAnswered = collect($student_quizzes)->sum("answer_count");
  $totalQuestions = collect($student_quizzes)->sum("question_count");
@endphp

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
