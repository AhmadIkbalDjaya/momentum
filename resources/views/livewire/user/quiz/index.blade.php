@php
  $breadcrumbs = [
    [
      "name" => "Quiz",
      "route" => "",
    ],
  ];
@endphp

<div>
  <x-breadcrumb :items="$breadcrumbs" />

  <div class="rounded-lg bg-white p-6 shadow-sm">
    <h1 class="text-primary font-bold">Quiz</h1>
    @if (count($quizzes) > 0)
      <div class="grid grid-cols-1 justify-between gap-2 py-3 md:grid-cols-3">
        @foreach ($quizzes as $quiz)
          <livewire:user.components.quiz-card :quiz="$quiz" />
        @endforeach
      </div>
    @else
      <div class="grid grid-cols-1 place-items-center gap-2 py-5">
        <div class="grid place-items-center">
          <img
            src="{{ asset("images/icons/out-of-stock.webp") }}"
            class="h-16"
            alt=""
            srcset=""
          />
          <p class="mt-2 font-medium text-gray-400">
            Belum Ada Quiz Yang Tersedia
          </p>
        </div>
      </div>
    @endif
  </div>
</div>
