<div>
  {{-- Because she competes with no one, no one can compete with her. --}}
  <div
    wire:click="openModal"
    class="flex cursor-pointer items-center justify-between pb-6 md:cursor-default md:gap-x-28"
  >
    <div class="flex items-center gap-x-1 md:grow">
      <img
        src="{{ asset("images/icons/parchment.webp") }}"
        class="h-10 w-10 rounded-full bg-gray-300 md:hidden"
      />
      <div
        class="flex flex-col text-nowrap text-xs font-medium md:grow md:flex-row md:justify-between md:text-base"
      >
        <p class="text-black">{{ $student_quiz["quiz_name"] }}</p>
        <p class="text-gray-500 md:text-black">
          {{ $student_quiz["quiz_type"] }}
        </p>
      </div>
    </div>
    <div
      class="flex flex-col text-nowrap text-end text-xs font-medium md:grow md:flex-row md:justify-between md:text-base"
    >
      <p class="text-black">
        {{ date("d-m-Y H:i", strtotime($student_quiz["work_date"])) }}
      </p>
      <p class="text-gray-500 md:text-black">
        Nilai: {{ $student_quiz["score"] }}
      </p>
    </div>
    <div class="hidden md:block">
      <button
        wire:click="openModal"
        class="rounded bg-momentum1 px-3 font-medium text-white"
      >
        Detail
      </button>
    </div>
  </div>

  @if ($isOpen)
    <div
      wire:click="closeModal"
      class="fixed inset-0 z-20 flex items-center justify-center bg-black bg-opacity-50"
    >
      <div class="w-96 rounded-lg bg-white md:w-4/12">
        <div class="flex items-center justify-between border-b px-4 py-2">
          <h3 class="text-lg font-semibold text-momentum1">
            Detail Pengerjaan
          </h3>
          <button wire:click="closeModal" class="text-black">
            <i class="fa-solid fa-xmark"></i>
          </button>
        </div>
        <div class="p-4">
          <div class="grid grid-cols-2 gap-y-2">
            <p>Nama Peserta</p>
            <p>: {{ $student_quiz["student_name"] }}</p>
            <p>Nama Quiz</p>
            <p>: {{ $student_quiz["quiz_name"] }}</p>
            <p>Jenis Soal</p>
            <p>: {{ $student_quiz["quiz_type"] }}</p>
            <p>Tanggal Pengerjaan</p>
            <p>
              :
              {{ date("d-m-Y H:i", strtotime($student_quiz["work_date"])) }}
            </p>
            <p>Durasi Pengerjaan</p>
            <p>: {{ $student_quiz["duration"] ?? "-" }} menit</p>
            <p>Jumlah Soal</p>
            <p>: {{ $student_quiz["question_count"] }} Soal</p>
            <p>Jumlah Soal Dijawab</p>
            <p>
              : {{ $student_quiz["answer_count"] }} /
              {{ $student_quiz["question_count"] }}
            </p>
            <p>Nilai</p>
            <p>: {{ $student_quiz["score"] }}</p>
          </div>
        </div>
        <div class="flex justify-end border-t px-4 py-2">
          <button
            wire:click="closeModal"
            class="mr-2 rounded bg-gray-200 px-4 py-1"
          >
            Tutup
          </button>
        </div>
      </div>
    </div>
  @endif
</div>
