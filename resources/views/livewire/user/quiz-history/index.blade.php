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

  <div class="space-y-4">
    <x-pages.quiz-history.summary-card :student_quizzes="$student_quizzes" />

    <x-pages.quiz-history.history-list :student_quizzes="$student_quizzes" />
  </div>
</div>
