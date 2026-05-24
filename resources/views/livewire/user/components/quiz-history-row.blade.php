<div x-data="detailModal">
  <div
    @click="toggleDetailModal()"
    class="flex cursor-pointer items-center justify-between pb-6 md:cursor-default md:gap-x-28"
  >
    <div class="flex items-center gap-x-1 md:grow">
      <img
        src="{{ asset("images/icons/parchment.webp") }}"
        class="h-10 w-10 rounded-full bg-gray-300 md:hidden"
      />
      <div
        class="flex flex-col text-xs font-medium text-nowrap md:grow md:flex-row md:justify-between md:text-base"
      >
        <p
          class="line-clamp-1 w-25 max-w-25 min-w-25 text-ellipsis whitespace-nowrap text-black md:w-30 md:max-w-30 md:min-w-30"
        >
          {{ $student_quiz["quiz_name"] }}
        </p>
        <p class="text-gray-500 md:w-24 md:min-w-20 md:text-black">
          {{ $student_quiz["quiz_type"] }}
        </p>
      </div>
    </div>
    <div
      class="flex flex-col text-end text-xs font-medium text-nowrap md:grow md:flex-row md:justify-between md:text-base"
    >
      <p class="text-black md:w-24 md:min-w-20">
        {{ date("d M Y H:i", strtotime($student_quiz["work_date"])) }}
      </p>
      <p class="text-gray-500 md:w-24 md:min-w-20 md:text-start md:text-black">
        Nilai: {{ $student_quiz["score"] }}
      </p>
    </div>
    <div class="hidden md:block">
      <button class="btn btn-primary rounded px-3 py-0">Detail</button>
    </div>
  </div>

  <div
    x-cloak
    x-show="show_detail_modal"
    @click="toggleDetailModal()"
    class="fixed inset-0 z-20 flex items-center justify-center bg-gray-900/50"
  >
    <div @click.stop class="w-96 rounded-lg bg-white md:w-4/12">
      <div
        class="flex items-center justify-between border-b border-gray-200 px-4 py-2"
      >
        <h3 class="text-primary text-lg font-semibold">Detail Pengerjaan</h3>
        <x-icons.x class="cursor-pointer" @click="toggleDetailModal()" />
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
            {{ date("d M Y H:i", strtotime($student_quiz["work_date"])) }}
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
      <div class="flex justify-end border-t border-gray-200 px-4 py-2">
        <button
          @click="toggleDetailModal()"
          class="mr-2 cursor-pointer rounded bg-gray-200 px-4 py-1 font-medium"
        >
          Tutup
        </button>
      </div>
    </div>
  </div>
</div>

@script
  <script>
    Alpine.data('detailModal', () => ({
      show_detail_modal: false,
      toggleDetailModal() {
        this.show_detail_modal = !this.show_detail_modal;
      },
    }));
  </script>
@endscript
