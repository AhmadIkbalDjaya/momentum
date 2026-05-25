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

  <div class="rounded-lg bg-white p-6 shadow-sm">
    <h1 class="text-primary font-bold">Detail Quiz</h1>
    <div class="mt-5 flex flex-wrap gap-x-10 gap-y-3 md:flex-nowrap">
      <div class="basis-full md:basis-7/12">
        <img
          src="{{ asset("images/quizzes/quiz-2.webp") }}"
          alt="{{ $quiz->name }}"
          srcset=""
          class="h-48 w-full rounded-md bg-gray-100 object-cover object-center md:h-72"
        />
      </div>
      <div class="basis-full md:basis-5/12">
        <div class="flex flex-col gap-y-5">
          <div class="flex">
            <div
              class="basis-5/12 font-medium text-gray-600 md:flex md:basis-5/12"
            >
              Nama Quiz
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $quiz->name }}
            </div>
          </div>
          <div class="flex">
            <div
              class="basis-5/12 font-medium text-gray-600 md:flex md:basis-5/12"
            >
              Jenis Quiz
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $quiz->quiz_type->description }}
            </div>
          </div>
          <div class="flex">
            <div
              class="basis-5/12 font-medium text-gray-600 md:flex md:basis-5/12"
            >
              <span class="hidden md:block">Tanggal &nbsp;</span>
              Mulai
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ date("d M Y - H:i", strtotime($quiz->start_time)) }}
            </div>
          </div>
          <div class="flex">
            <div
              class="basis-5/12 font-medium text-gray-600 md:flex md:basis-5/12"
            >
              <span class="hidden md:block">Tanggal &nbsp;</span>
              Selesai
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ date("d M Y - H:i", strtotime($quiz->end_time)) }}
            </div>
          </div>
          <div class="flex">
            <div
              class="basis-5/12 font-medium text-gray-600 md:flex md:basis-5/12"
            >
              Durasi&nbsp;
              <span class="hidden md:block">Pengerjaan</span>
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $quiz->duration }} Menit
            </div>
          </div>
          <div class="flex">
            <div
              class="basis-5/12 font-medium text-gray-600 md:flex md:basis-5/12"
            >
              Status&nbsp;
              <span class="hidden md:block">Pengerjaan</span>
            </div>
            <div class="basis-7/12 text-gray-500 md:grow">
              {{ $has_work ? "Telah" : "Belum" }} Dikerjakan
            </div>
          </div>

          @if ($has_work)
            <a
              wire:navigate
              href="{{ route("quiz.history") }}"
              class="btn btn-primary btn-full rounded px-2 py-1"
            >
              Lihat History Pengerjaan
            </a>
          @elseif ($has_end)
            <button
              class="btn btn-primary btn-full cursor-default rounded px-2 py-1"
            >
              Quiz Telah Berakhir
            </button>
          @elseif ($has_begin == false)
            <button
              class="btn btn-primary btn-full cursor-default rounded px-2 py-1"
            >
              Quiz Belum Dimulai
            </button>
          @else
            <button
              @click="show_code_modal = true"
              class="btn btn-primary btn-full rounded px-2 py-1"
            >
              Kerjakan Quiz
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
    class="fixed inset-0 z-20 flex items-center justify-center bg-gray-900/50"
  >
    <div @click.stop class="w-10/12 rounded-lg bg-white p-6 md:w-1/3">
      <form @submit.prevent="$wire.checkCode(quiz_code)">
        <div class="mb-4 flex items-center justify-between">
          <h2 class="text-xl font-medium">Masukkan Kode Quiz</h2>
          <x-icons.x class="cursor-pointer" @click="closeCodeModal()" />
        </div>
        <div class="mb-2 py-2">
          <input
            x-model="quiz_code"
            type="text"
            class="focus:outline-primary block w-full rounded border border-gray-300 bg-gray-50 p-2.5 text-sm text-gray-900"
            placeholder="Kode Quiz"
          />
          <div class="px-1">
            <x-input-error-message name="quiz_code" />
          </div>
        </div>
        <div class="mt-4 flex justify-between">
          <button
            @click="closeCodeModal()"
            type="button"
            class="cursor-pointer rounded-md bg-red-700 px-3 py-1.5 text-center text-sm font-medium text-white hover:bg-red-800 focus:ring-red-300 focus:outline-none"
          >
            Tutup
          </button>
          <button
            type="submit"
            class="btn btn-primary rounded-md px-3 py-1.5 text-sm"
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
