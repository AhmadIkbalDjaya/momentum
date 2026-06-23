@props([
  "student_quizzes" => [],
])

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
