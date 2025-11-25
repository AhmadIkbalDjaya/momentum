<a
  wire:navigate
  href="{{ route("quiz.show", ["quiz" => $quiz->id]) }}"
  class="relative h-52 rounded-md bg-gray-300 bg-cover bg-center bg-no-repeat"
  style="
    background-image: url('{{ asset("images/quizzes/quiz-" . $rand_img . ".webp") }}');
  "
>
  <div class="absolute bottom-4 w-full">
    <div class="flex justify-end">
      <span
        class="mx-4 rounded bg-white px-1 text-[12px] font-medium text-primary"
      >
        {{ $quiz->quiz_type->description }}
      </span>
    </div>
    <p
      class="mx-4 rounded-md bg-black/35 p-2 text-sm font-medium text-white backdrop-blur-sm"
    >
      {{ $quiz->name }}
    </p>
  </div>
  <p
    class="absolute left-3 top-3 rounded bg-white p-1 text-xs font-medium text-primary"
  >
    {{ $quiz->duration }} min
  </p>
</a>
