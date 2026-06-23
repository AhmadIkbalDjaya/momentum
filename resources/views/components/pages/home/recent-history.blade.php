@props([
  "student_quizzes" => [],
])

<div class="rounded-lg bg-white shadow-sm lg:col-span-4">
  <div
    class="flex flex-wrap items-center justify-between gap-2 border-b border-gray-100 px-4 py-4"
  >
    <div class="text-primary flex items-center gap-x-2">
      <x-icons.clock-rotate-left class="h-5 w-5" />
      <h1 class="font-bold">Riwayat Terakhir</h1>
    </div>
    @if (count($student_quizzes) > 0)
      <a
        wire:navigate
        href="{{ route("quiz.history") }}"
        class="text-primary flex items-center gap-x-1 text-sm font-bold"
      >
        <span>Lihat Semua</span>
        <x-icons.angle-right class="h-3.5 w-3.5" />
      </a>
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
    <div class="grid min-h-32 place-items-center px-4 py-6">
      <div class="grid place-items-center">
        <img
          src="{{ asset("images/icons/out-of-stock.webp") }}"
          class="h-16"
          alt="Empty Quiz"
          srcset=""
        />
        <p class="mt-2 text-sm font-medium text-gray-400">
          Belum Ada Quiz Yang Dikerjakan
        </p>
      </div>
    </div>
  @endif
</div>
