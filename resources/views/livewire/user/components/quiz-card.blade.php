@php
  $studentQuiz = $quiz->relationLoaded("student_quiz")
    ? $quiz->student_quiz->first()
    : null;
  $workStatus = match (true) {
    $studentQuiz === null => [
      "label" => "Belum Dikerjakan",
      "class" => "bg-blue-500/10 text-blue-500",
    ],
    $studentQuiz->is_done => [
      "label" => "Selesai",
      "class" => "bg-green-500/10 text-green-700",
    ],
    default => [
      "label" => "Belum Selesai",
      "class" => "bg-yellow-500/10 text-yellow-600",
    ],
  };
@endphp

<div class="overflow-hidden rounded-lg bg-white shadow-sm ring-1 ring-gray-200">
  <a
    wire:navigate
    href="{{ route("quiz.show", ["quiz" => $quiz->id]) }}"
    class="relative block h-40 bg-gray-300 bg-cover bg-center bg-no-repeat"
    style="
      background-image: url('{{ asset("images/quizzes/quiz-" . $rand_img . ".webp") }}');
    "
  >
    <span
      class="bg-primary absolute top-3 left-3 rounded-md px-3 py-1 text-xs font-bold text-white shadow-sm"
    >
      {{ $quiz->duration }} min
    </span>
    <span
      class="text-primary absolute top-3 right-3 rounded-md bg-white px-3 py-1 text-xs font-bold shadow-sm"
    >
      {{ $quiz->type->label() }}
    </span>
  </a>

  <div class="px-3 pt-3 pb-3">
    <a
      wire:navigate
      href="{{ route("quiz.show", ["quiz" => $quiz->id]) }}"
      class="hover:text-primary block truncate text-base font-bold text-gray-800"
    >
      {{ $quiz->name }}
    </a>

    <div
      class="mt-3 flex flex-wrap items-center gap-x-3 gap-y-2 text-sm text-gray-500"
    >
      <div class="flex items-center gap-x-1">
        <x-icons.file-description class="h-4 w-4" />
        <span>{{ $quiz->type->label() }}</span>
      </div>
      <div class="flex items-center gap-x-1">
        <x-icons.list class="h-4 w-4" />
        <span>
          {{ $quiz->questions_count ?? $quiz->questions()->count() }} soal
        </span>
      </div>
      <div class="flex items-center gap-x-1">
        <x-icons.clock-hour-4 class="h-4 w-4" />
        <span>{{ $quiz->duration }} menit</span>
      </div>
    </div>

    <div class="mt-4 flex items-center justify-between gap-3">
      <span
        class="{{ $workStatus["class"] }} rounded-md px-3 py-1.5 text-xs font-bold whitespace-nowrap"
      >
        {{ $workStatus["label"] }}
      </span>
      <a
        wire:navigate
        href="{{ route("quiz.show", ["quiz" => $quiz->id]) }}"
        class="btn btn-primary rounded-md px-3 py-2 text-xs whitespace-nowrap"
      >
        Kerjakan Quiz
        <x-icons.angle-right class="hidden h-4 w-4 md:inline-block" />
      </a>
    </div>
  </div>
</div>
