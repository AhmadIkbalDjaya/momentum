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

  <x-pages.quiz.available-quizzes :quizzes="$quizzes" />
</div>
