@props([
  "quiz" => null,
  "questions" => [],
])

<div class="rounded-lg bg-white p-6 shadow-sm">
  <h6 class="mb-5 font-semibold text-gray-700">Daftar Soal</h6>
  <div class="grid grid-cols-5 gap-3">
    @foreach ($questions as $index => $question)
      <button
        x-on:click="setActiveQuestion('set', {{ $loop->iteration }})"
        x-bind:class="
          active_question == {{ $loop->iteration }}
            ? 'border-primary text-primary bg-white'
            : $wire.selected_options[{{ $index }}] != null
              ? 'border-green-500 bg-green-50 text-green-700'
              : 'border-gray-200 bg-white text-gray-700'
        "
        class="hover:border-primary hover:text-primary flex aspect-square items-center justify-center rounded-md border text-sm font-semibold shadow-sm transition"
      >
        {{ $loop->iteration }}
      </button>
    @endforeach
  </div>

  <div class="mt-5 flex flex-wrap gap-x-4 gap-y-3 text-xs text-gray-600">
    <div class="flex items-center gap-x-2">
      <div class="border-primary h-3 w-3 rounded-full border-2"></div>
      <p>Sedang Dikerjakan</p>
    </div>
    @if ($quiz->type !== \App\Enums\QuizType::Essay)
      <div class="flex items-center gap-x-2">
        <div class="h-3 w-3 rounded-full bg-green-700"></div>
        <p>Terjawab</p>
      </div>
      <div class="flex items-center gap-x-2">
        <div class="h-3 w-3 rounded-full border border-gray-300"></div>
        <p>Belum Dijawab</p>
      </div>
    @endif
  </div>

  @if ($quiz->type !== \App\Enums\QuizType::Essay)
    <div class="mt-6 border-t border-gray-200 pt-4">
      <p class="text-sm text-gray-500">
        <span
          class="font-semibold text-gray-700"
          x-text="answeredCount()"
        ></span>
        /
        <span>{{ count($questions) }}</span>
        terjawab
      </p>
      <div class="mt-3 h-2 overflow-hidden rounded-full bg-gray-200">
        <div
          class="h-full rounded-full bg-green-700 transition-all"
          x-bind:style="`width: ${answeredPercent()}%`"
        ></div>
      </div>
    </div>
  @endif
</div>
