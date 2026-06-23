@props([
  "quizzes" => [],
])

<div class="rounded-lg bg-white p-5 shadow-sm">
  <div class="mb-2.5 flex items-center justify-between">
    <div class="text-primary flex items-center gap-x-1">
      <x-icons.stack-2 class="h-5 w-5" />
      <h1 class="font-bold">Quiz Tersedia</h1>
    </div>
    @if (count($quizzes) > 0)
      <a
        wire:navigate
        href="{{ route("quiz.index") }}"
        class="text-primary hidden items-center gap-x-1 text-sm font-medium md:flex"
      >
        <span>Lihat Semua</span>
        <x-icons.angle-right class="h-3.5 w-3.5" />
      </a>
    @endif
  </div>
  @if (count($quizzes) > 0)
    <div class="grid grid-cols-1 justify-between gap-3 py-3 md:grid-cols-3">
      @foreach ($quizzes as $quiz)
        <livewire:user.components.quiz-card :quiz="$quiz" />
      @endforeach
    </div>
    <a
      wire:navigate
      href="{{ route("quiz.index") }}"
      class="text-primary flex items-center justify-end gap-x-1 text-sm font-medium md:hidden"
    >
      <span>Lihat Semua</span>
      <x-icons.angle-right class="h-3.5 w-3.5" />
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
