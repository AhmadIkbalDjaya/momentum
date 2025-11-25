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
  {{-- quiz code modal --}}
  <div
    x-cloak
    x-show="show_code_modal"
    @click="closeCodeModal()"
    x-transition.opacity
    class="fixed inset-0 z-20 flex items-center justify-center bg-gray-900 bg-opacity-50"
  >
    <div @click.stop class="w-10/12 rounded-lg bg-white p-6 md:w-1/3">
      <form @submit.prevent="$wire.checkCode(quiz_code)">
        <div class="mb-4 flex items-center justify-between">
          <h2 class="text-xl font-medium">Masukkan Kode Quiz</h2>
          <svg
            @click="closeCodeModal()"
            class="h-3 w-3 cursor-pointer"
            aria-hidden="true"
            xmlns="http://www.w3.org/2000/svg"
            fill="none"
            viewBox="0 0 14 14"
          >
            <path
              stroke="currentColor"
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"
            />
          </svg>
        </div>
        <div class="mb-2 py-2">
          <input
            x-model="quiz_code"
            type="text"
            class="block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900 focus:outline-primary"
            placeholder="Kode Quiz"
          />
          <div class="px-1">
            @error("quiz_code")
              <livewire:components.input-error-message field="quiz_code" />
            @enderror
          </div>
        </div>
        <div class="mt-4 flex justify-between">
          <button
            @click="closeCodeModal()"
            type="button"
            class="rounded-md bg-red-700 px-3 py-1.5 text-center text-sm font-medium text-white hover:bg-red-800 focus:outline-none focus:ring-red-300"
          >
            Tutup
          </button>
          <button
            type="submit"
            class="flex items-center justify-center gap-x-1 rounded-md bg-primary px-3 py-1.5 text-center text-sm font-medium text-white hover:bg-primary focus:outline-none focus:ring-primary"
          >
            <x-loading-icon target="checkCode" />
            Mulai
          </button>
        </div>
      </form>
    </div>
  </div>

  <x-breadcrumb :items="$breadcrumbs" />

  <div class="rounded-lg bg-white p-6 shadow-sm">
    <h1 class="font-bold text-primary">Detail Quiz</h1>
    <div class="mt-5 flex flex-wrap gap-x-10 gap-y-3 md:flex-nowrap">
      <div class="basis-full md:basis-7/12">
        <div
          class="h-48 w-full rounded-md bg-cover bg-center bg-no-repeat md:h-72"
          style="
            background-image: url('{{ asset("images/quizzes/quiz-2.webp") }}');
          "
        ></div>
      </div>
      <div class="basis-full md:basis-5/12">
        <div class="flex flex-col gap-y-5">
          <div class="flex">
            <div class="basis-5/12 font-medium text-gray-600 md:basis-5/12">
              Nama Quiz
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $quiz->name }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-5/12 font-medium text-gray-600 md:basis-5/12">
              Jenis Quiz
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $quiz->quiz_type->description }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-5/12 font-medium text-gray-600 md:basis-5/12">
              Tanggal Mulai
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ date("d M Y (H:i)", strtotime($quiz->start_time)) }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-5/12 font-medium text-gray-600 md:basis-5/12">
              Tanggal Selesai
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ date("d M Y (H:i)", strtotime($quiz->end_time)) }}
            </div>
          </div>
          <div class="flex">
            <div class="basis-5/12 font-medium text-gray-600 md:basis-5/12">
              Durasi Pengerjaan
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $quiz->duration }} Menit
            </div>
          </div>
          <div class="flex">
            <div class="basis-5/12 font-medium text-gray-600 md:basis-5/12">
              Status Pengerjaan
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $has_work ? "Telah" : "Belum" }} Dikerjakan
            </div>
          </div>

          @if ($has_work)
            <a
              wire:navigate
              href="{{ route("quiz.history") }}"
              class="w-full rounded bg-primary px-2 py-1 text-center font-medium text-white"
            >
              Lihat History Pengerjaan
            </a>
          @elseif ($has_end)
            <button
              class="w-full cursor-default rounded bg-primary px-2 py-1 text-center font-medium text-white"
            >
              Quiz Telah Berakhir
            </button>
          @elseif ($has_begin == false)
            <button
              class="w-full cursor-default rounded bg-primary px-2 py-1 text-center font-medium text-white"
            >
              Quiz Belum Dimulai
            </button>
          @else
            <button
              @click="show_code_modal = true"
              class="w-full rounded bg-primary px-2 py-1 text-center font-medium text-white"
            >
              Kerjakan Quiz
            </button>
          @endif
        </div>
      </div>
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
