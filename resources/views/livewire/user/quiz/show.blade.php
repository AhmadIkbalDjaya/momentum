@php
  $breadcrumbs = [
    [
      "name" => "Quiz",
      "route" => "quiz.index",
    ],
    [
      "name" => $quiz->name,
      "route" => "",
    ],
  ];
@endphp

<div x-data="codeModal" @keydown.escape.window="closeCodeModal()">
  <x-breadcrumb :items="$breadcrumbs" />

  <x-pages.quiz.detail-card
    :quiz="$quiz"
    :has_work="$has_work"
    :has_end="$has_end"
    :has_begin="$has_begin"
  />

  <x-pages.quiz.code-modal />
</div>

@script
  <script>
    Alpine.data('codeModal', () => ({
      show_code_modal: false,
      quiz_code: '',
      closeCodeModal() {
        this.show_code_modal = false;
        this.quiz_code = '';
        $wire.clearValidation('quiz_code');
      },
    }));
  </script>
@endscript
