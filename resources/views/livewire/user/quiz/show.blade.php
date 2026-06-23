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

  @php
    $status = match (true) {
      (bool) $has_work => [
        "label" => "Telah Dikerjakan",
        "description" => "Kamu sudah menyelesaikan quiz ini.",
        "class" => "bg-green-500/10 text-green-600",
        "icon" => "circle-check",
      ],
      (bool) $has_end => [
        "label" => "Quiz Telah Berakhir",
        "description" => "Waktu pengerjaan quiz ini sudah selesai.",
        "class" => "bg-red-500/10 text-red-500",
        "icon" => "clock",
      ],
      $has_begin == false => [
        "label" => "Quiz Belum Dimulai",
        "description" => "Quiz akan dapat dikerjakan setelah waktu mulai.",
        "class" => "bg-yellow-500/10 text-yellow-600",
        "icon" => "clock",
      ],
      default => [
        "label" => "Siap Dikerjakan",
        "description" => "Masukkan kode quiz untuk mulai mengerjakan.",
        "class" => "bg-primary/10 text-primary",
        "icon" => "circle-check",
      ],
    };
  @endphp

  <div class="overflow-hidden rounded-lg bg-white shadow-sm">
    <div class="grid grid-cols-1 md:grid-cols-12">
      <div class="relative md:col-span-7">
        <img
          src="{{ asset("images/quizzes/quiz-2.webp") }}"
          alt="{{ $quiz->name }}"
          srcset=""
          class="h-56 w-full bg-gray-100 object-cover object-center md:h-full md:min-h-96"
        />
        <div class="absolute top-4 left-4 flex flex-wrap gap-2">
          <span
            class="bg-primary rounded-md px-3 py-1 text-xs font-bold text-white shadow-sm"
          >
            {{ $quiz->duration }} min
          </span>
          <span
            class="text-primary rounded-md bg-white px-3 py-1 text-xs font-bold shadow-sm"
          >
            {{ $quiz->type->label() }}
          </span>
        </div>
      </div>

      <div class="p-5 md:col-span-5 md:p-6">
        <div>
          <p class="text-primary text-xs font-bold uppercase">Detail Quiz</p>
          <h1 class="mt-1 text-2xl font-bold text-gray-800">
            {{ $quiz->name }}
          </h1>
          <p class="mt-3 text-sm leading-relaxed font-medium text-gray-500">
            Periksa informasi quiz sebelum mulai mengerjakan.
          </p>
        </div>

        <div class="mt-5 grid grid-cols-2 gap-3">
          <div class="rounded-lg bg-gray-50 p-3">
            <div
              class="text-primary bg-primary/10 mb-2 grid h-8 w-8 place-items-center rounded-md"
            >
              <x-icons.file-description class="h-4 w-4" />
            </div>
            <p class="text-xs font-semibold text-gray-500">Jenis Quiz</p>
            <p class="mt-1 text-sm font-bold text-gray-800">
              {{ $quiz->type->label() }}
            </p>
          </div>
          <div class="rounded-lg bg-gray-50 p-3">
            <div
              class="text-primary bg-primary/10 mb-2 grid h-8 w-8 place-items-center rounded-md"
            >
              <x-icons.clock-hour-4 class="h-4 w-4" />
            </div>
            <p class="text-xs font-semibold text-gray-500">Durasi</p>
            <p class="mt-1 text-sm font-bold text-gray-800">
              {{ $quiz->duration }} Menit
            </p>
          </div>
        </div>

        <div class="mt-4 space-y-3">
          <div class="rounded-lg border border-gray-100 p-3">
            <p class="text-xs font-semibold text-gray-500">Mulai</p>
            <p class="mt-1 text-sm font-bold text-gray-800">
              {{ date("d M Y - H:i", strtotime($quiz->start_time)) }}
            </p>
          </div>
          <div class="rounded-lg border border-gray-100 p-3">
            <p class="text-xs font-semibold text-gray-500">Selesai</p>
            <p class="mt-1 text-sm font-bold text-gray-800">
              {{ date("d M Y - H:i", strtotime($quiz->end_time)) }}
            </p>
          </div>
        </div>

        <div class="{{ $status["class"] }} mt-4 rounded-lg p-4">
          <div class="flex items-start gap-3">
            @if ($status["icon"] === "clock")
              <x-icons.clock-hour-4 class="mt-0.5 h-5 w-5 shrink-0" />
            @else
              <x-icons.circle-check class="mt-0.5 h-5 w-5 shrink-0" />
            @endif
            <div>
              <p class="font-bold">{{ $status["label"] }}</p>
              <p class="mt-1 text-sm font-medium opacity-80">
                {{ $status["description"] }}
              </p>
            </div>
          </div>
        </div>

        <div class="mt-5">
          @if ($has_work)
            <a
              wire:navigate
              href="{{ route("quiz.history") }}"
              class="btn btn-primary btn-full rounded-md px-4 py-2.5"
            >
              Lihat History Pengerjaan
              <x-icons.angle-right class="h-4 w-4" />
            </a>
          @elseif ($has_end)
            <button
              class="btn btn-primary btn-full cursor-default rounded-md px-4 py-2.5 opacity-70"
            >
              Quiz Telah Berakhir
            </button>
          @elseif ($has_begin == false)
            <button
              class="btn btn-primary btn-full cursor-default rounded-md px-4 py-2.5 opacity-70"
            >
              Quiz Belum Dimulai
            </button>
          @else
            <button
              @click="show_code_modal = true"
              class="btn btn-primary btn-full rounded-md px-4 py-2.5"
            >
              Kerjakan Quiz
              <x-icons.angle-right class="h-4 w-4" />
            </button>
          @endif
        </div>
      </div>
    </div>
  </div>

  {{-- quiz code modal --}}
  <div
    x-cloak
    x-show="show_code_modal"
    @click="closeCodeModal()"
    x-transition.opacity
    class="fixed inset-0 z-20 flex items-end justify-center bg-gray-900/50 p-0 sm:items-center sm:p-4"
  >
    <div
      @click.stop
      x-transition
      class="w-full rounded-t-xl bg-white p-5 shadow-lg sm:max-w-md sm:rounded-xl"
    >
      <form @submit.prevent="$wire.checkCode(quiz_code)">
        <div class="mb-4 flex items-start justify-between gap-3">
          <div>
            <h2 class="text-primary text-xl font-bold">Masukkan Kode Quiz</h2>
            <p class="mt-1 text-sm font-medium text-gray-500">
              Gunakan kode yang diberikan untuk memulai quiz.
            </p>
          </div>
          <button
            type="button"
            @click="closeCodeModal()"
            class="grid h-9 w-9 shrink-0 cursor-pointer place-items-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200"
          >
            <x-icons.x class="h-4 w-4" />
          </button>
        </div>
        <div class="mb-2">
          <label class="mb-2 block text-sm font-bold text-gray-700">
            Kode Quiz
          </label>
          <input
            x-model="quiz_code"
            type="text"
            class="focus:outline-primary block w-full rounded-md border border-gray-300 bg-gray-50 p-3 text-center text-lg font-bold tracking-wide text-gray-900 uppercase"
            placeholder="Kode Quiz"
          />
          <div class="px-1">
            <x-input-error-message name="quiz_code" />
          </div>
        </div>
        <div class="mt-5 grid grid-cols-2 gap-3">
          <button
            @click="closeCodeModal()"
            type="button"
            class="cursor-pointer rounded-md bg-gray-100 px-4 py-2.5 text-center text-sm font-bold text-gray-600 hover:bg-gray-200"
          >
            Tutup
          </button>
          <button
            type="submit"
            class="btn btn-primary rounded-md px-4 py-2.5 text-sm"
          >
            <x-loading-icon target="checkCode" />
            Mulai
          </button>
        </div>
      </form>
    </div>
  </div>
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
