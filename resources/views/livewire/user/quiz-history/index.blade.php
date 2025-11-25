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

  <div class="rounded-lg bg-white px-4 py-5 shadow-sm">
    <h1 class="font-bold text-primary">Quiz yang telah dikerjakan</h1>
    <div class="mt-5">
      @if (count($student_quizzes) > 0)
        @foreach ($student_quizzes as $student_quiz)
          <livewire:user.components.quiz-history-row
            :student_quiz="$student_quiz"
          />
        @endforeach
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
              Belum Ada Quiz Yang Dikerjakan
            </p>
          </div>
        </div>
      @endif
    </div>
  </div>
</div>
