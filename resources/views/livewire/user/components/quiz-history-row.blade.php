<div x-data="detailModal" @keydown.escape.window="closeDetailModal()">
  @php
    $scoreValue = $student_quiz["score"] !== null ? explode(" ", $student_quiz["score"])[0] : null;
    $isTrueFalse = str_contains($student_quiz["quiz_type"], "Benar");
    $answerPercent = $student_quiz["question_count"] > 0 ? round(($student_quiz["answer_count"] / $student_quiz["question_count"]) * 100) : 0;
  @endphp

  @if ($compact)
    <div
      @click="toggleDetailModal()"
      class="flex cursor-pointer flex-col gap-3 border-b border-gray-100 px-4 py-3 last:border-b-0 sm:flex-row sm:items-center"
    >
      <div class="flex min-w-0 items-start gap-3 sm:flex-1 sm:items-center">
        <div
          class="{{ $isTrueFalse ? "bg-blue-500/10 text-blue-500" : "bg-green-500/10 text-green-600" }} flex h-11 w-11 shrink-0 items-center justify-center rounded-md"
        >
          @if ($isTrueFalse)
            <x-icons.globe class="h-5 w-5" />
          @else
            <x-icons.flag class="h-5 w-5" />
          @endif
        </div>

        <div class="min-w-0 flex-1">
          <p class="truncate text-sm font-bold text-gray-800">
            {{ $student_quiz["quiz_name"] }}
          </p>
          <div
            class="mt-1 flex flex-wrap items-center gap-x-2 gap-y-1 text-xs font-medium text-gray-500"
          >
            <span>{{ $student_quiz["quiz_type"] }}</span>
            <span>&bull;</span>
            <span>{{ $student_quiz["question_count"] }} soal</span>
            <span>&bull;</span>
            <span>{{ $student_quiz["quiz_duration"] }} menit</span>
          </div>
        </div>

        <x-icons.angle-right class="h-4 w-4 shrink-0 text-gray-500 sm:hidden" />
      </div>

      <div class="flex items-center justify-between gap-3 ps-14 sm:ps-0">
        <span
          class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-bold text-green-600"
        >
          Selesai
        </span>

        <div class="text-center">
          <p class="text-xs font-medium text-gray-500">Nilai</p>
          <p class="text-primary text-xl leading-none font-bold">
            @if ($student_quiz["score"] !== null)
              {{ $scoreValue }}
            @else
              <span
                class="bg-primary/10 text-primary inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-bold"
              >
                <x-icons.lock class="h-3.5 w-3.5" />
                -
              </span>
            @endif
          </p>
        </div>

        <x-icons.angle-right
          class="hidden h-4 w-4 shrink-0 text-gray-500 sm:block"
        />
      </div>
    </div>
  @else
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
        <p
          class="text-gray-500 md:w-24 md:min-w-20 md:text-start md:text-black"
        >
          Nilai:
          @if ($student_quiz["score"] !== null)
            {{ $student_quiz["score"] }}
          @else
            <span
              class="bg-primary/10 text-primary inline-flex items-center gap-1 rounded-full px-2 py-1 text-xs font-bold"
            >
              <x-icons.lock class="h-3.5 w-3.5" />
              Disembunyikan
            </span>
          @endif
        </p>
      </div>
      <div class="hidden md:block">
        <button class="btn btn-primary rounded px-3 py-0">Detail</button>
      </div>
    </div>
  @endif

  <div
    x-cloak
    x-show="show_detail_modal"
    @click="closeDetailModal()"
    x-transition.opacity
    class="fixed inset-0 z-20 flex items-end justify-center bg-gray-900/50 p-0 sm:items-center sm:p-4"
  >
    <div
      @click.stop
      x-transition
      class="max-h-[90vh] w-full overflow-y-auto rounded-t-xl bg-white shadow-lg sm:w-11/12 sm:max-w-xl sm:rounded-xl"
    >
      <div
        class="flex items-start justify-between gap-3 border-b border-gray-100 px-5 py-4"
      >
        <div class="flex min-w-0 items-start gap-3">
          <div
            class="{{ $isTrueFalse ? "bg-blue-500/10 text-blue-500" : "bg-green-500/10 text-green-600" }} flex h-11 w-11 shrink-0 items-center justify-center rounded-lg"
          >
            @if ($isTrueFalse)
              <x-icons.globe class="h-5 w-5" />
            @else
              <x-icons.flag class="h-5 w-5" />
            @endif
          </div>
          <div class="min-w-0">
            <h3 class="text-primary text-lg font-bold">Detail Pengerjaan</h3>
            <p class="mt-1 truncate text-sm font-semibold text-gray-800">
              {{ $student_quiz["quiz_name"] }}
            </p>
          </div>
        </div>
        <button
          type="button"
          @click="closeDetailModal()"
          class="grid h-9 w-9 shrink-0 cursor-pointer place-items-center rounded-full bg-gray-100 text-gray-500 hover:bg-gray-200"
        >
          <x-icons.x class="h-4 w-4" />
        </button>
      </div>

      <div class="space-y-4 p-5">
        <div class="grid grid-cols-1 gap-3 sm:grid-cols-3">
          <div class="bg-primary/10 rounded-lg p-4 text-center sm:col-span-1">
            <p class="text-primary text-xs font-bold">Nilai</p>
            @if ($student_quiz["score"] !== null)
              <p class="text-primary mt-1 text-4xl leading-none font-bold">
                {{ $scoreValue }}
              </p>
              <p class="mt-1 text-xs font-medium text-gray-500">dari 100</p>
            @else
              <span
                class="text-primary mt-2 inline-flex items-center gap-1 rounded-full bg-white px-3 py-1.5 text-xs font-bold"
              >
                <x-icons.lock class="h-3.5 w-3.5" />
                Disembunyikan
              </span>
            @endif
          </div>

          <div class="rounded-lg border border-gray-100 p-4 sm:col-span-2">
            <div class="flex flex-wrap items-center gap-2">
              <span
                class="rounded-full bg-green-500/10 px-3 py-1 text-xs font-bold text-green-600"
              >
                Selesai
              </span>
              <span
                class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600"
              >
                {{ $student_quiz["quiz_type"] }}
              </span>
            </div>
            <div class="mt-4">
              <div class="flex items-center justify-between gap-3 text-sm">
                <p class="font-semibold text-gray-700">Jawaban</p>
                <p class="font-bold text-gray-800">
                  {{ $student_quiz["answer_count"] }} /
                  {{ $student_quiz["question_count"] }}
                </p>
              </div>
              <div class="mt-2 h-2 overflow-hidden rounded-full bg-gray-200">
                <div
                  class="bg-primary h-full rounded-full"
                  style="width: {{ $answerPercent }}%"
                ></div>
              </div>
            </div>
          </div>
        </div>

        <div class="grid grid-cols-1 gap-3 text-sm sm:grid-cols-2">
          <div class="rounded-lg bg-gray-50 p-3">
            <p class="text-xs font-semibold text-gray-500">Peserta</p>
            <p class="mt-1 font-bold text-gray-800">
              {{ $student_quiz["student_name"] }}
            </p>
          </div>
          <div class="rounded-lg bg-gray-50 p-3">
            <p class="text-xs font-semibold text-gray-500">
              Tanggal Pengerjaan
            </p>
            <p class="mt-1 font-bold text-gray-800">
              {{ date("d M Y H:i", strtotime($student_quiz["work_date"])) }}
            </p>
          </div>
          <div class="rounded-lg bg-gray-50 p-3">
            <p class="text-xs font-semibold text-gray-500">Durasi Pengerjaan</p>
            <p class="mt-1 font-bold text-gray-800">
              {{ $student_quiz["duration"] ?? "-" }} menit
            </p>
          </div>
          <div class="rounded-lg bg-gray-50 p-3">
            <p class="text-xs font-semibold text-gray-500">Jumlah Soal</p>
            <p class="mt-1 font-bold text-gray-800">
              {{ $student_quiz["question_count"] }} Soal
            </p>
          </div>
        </div>
      </div>

      <div class="border-t border-gray-100 px-5 py-4">
        <button
          type="button"
          @click="closeDetailModal()"
          class="btn btn-primary w-full rounded-md px-4 py-2 text-sm"
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
      closeDetailModal() {
        this.show_detail_modal = false;
      },
    }));
  </script>
@endscript
