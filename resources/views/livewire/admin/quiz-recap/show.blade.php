<div class="space-y-5">
  <x-filament::section>
    <div class="flex flex-col-reverse gap-6 md:flex-row md:items-center">
      <dl
        class="grid flex-1 grid-cols-[max-content_1fr] gap-x-4 gap-y-2 text-sm"
      >
        <dt class="font-medium text-gray-500 dark:text-gray-400">Nama</dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ $quiz->name }}
        </dd>
        <dt class="font-medium text-gray-500 dark:text-gray-400">Kode</dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ $quiz->code }}
        </dd>
        <dt class="font-medium text-gray-500 dark:text-gray-400">
          Jenis Sekolah
        </dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ $quiz->school_category->name }}
        </dd>
        <dt class="font-medium text-gray-500 dark:text-gray-400">Jenis Kuis</dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ $quiz->quiz_type->description }}
        </dd>
        <dt class="font-medium text-gray-500 dark:text-gray-400">
          Waktu Mulai
        </dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ date("d M Y H:i", strtotime($quiz->start_time)) }}
        </dd>
        <dt class="font-medium text-gray-500 dark:text-gray-400">
          Waktu Selesai
        </dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ date("d M Y H:i", strtotime($quiz->end_time)) }}
        </dd>
        <dt class="font-medium text-gray-500 dark:text-gray-400">
          Durasi Pengerjaan
        </dt>
        <dd class="font-medium text-gray-950 dark:text-white">
          : {{ $quiz->duration }} Menit
        </dd>
      </dl>
      <div class="mx-auto w-40 shrink-0 md:mx-0">
        <img
          src="{{ asset("images/icons/quiz.webp") }}"
          alt=""
          srcset=""
          class="w-full"
        />
      </div>
    </div>
  </x-filament::section>

  <div class="fi-ta-ctn">
    <div class="overflow-x-auto">
      <table class="fi-ta-table">
        <thead>
          <tr>
            <th class="fi-ta-header-cell">Ranking</th>
            <th class="fi-ta-header-cell">Nama</th>
            <th class="fi-ta-header-cell">Sekolah</th>
            <th class="fi-ta-header-cell">Nilai</th>
            <th class="fi-ta-header-cell">Detail</th>
          </tr>
        </thead>
        <tbody>
          @foreach ($student_quizzes as $student_quiz)
            <tr class="fi-ta-row">
              <td
                class="px-3 py-3 text-sm font-medium text-nowrap whitespace-nowrap text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $loop->iteration }}
              </td>
              <td
                class="px-3 py-3 text-sm font-medium whitespace-nowrap text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $student_quiz->student->name }}
              </td>
              <td
                class="px-3 py-3 text-sm text-nowrap text-gray-500 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-gray-400"
              >
                {{ $student_quiz->student->school->name }}
              </td>
              <td
                class="px-3 py-3 text-sm font-medium text-nowrap text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $student_quiz->score }}
              </td>
              <td
                class="px-3 py-3 text-sm text-nowrap sm:first-of-type:ps-6 sm:last-of-type:pe-6"
              >
                <x-filament::button
                  wire:click="openModal({{ $student_quiz->id }}, {{ $loop->iteration }})"
                  type="button"
                  color="gray"
                  size="sm"
                >
                  Lihat
                </x-filament::button>
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>

  <div class="flex justify-end">
    <x-filament::button
      tag="a"
      href="{{ route('admin.quiz.recap', ['quiz' => $quiz->id]) }}"
      target="_blank"
      color="gray"
      size="sm"
    >
      <svg
        class="h-5 w-5"
        aria-hidden="true"
        xmlns="http://www.w3.org/2000/svg"
        width="24"
        height="24"
        fill="currentColor"
        viewBox="0 0 24 24"
      >
        <path
          fill-rule="evenodd"
          d="M9 2.221V7H4.221a2 2 0 0 1 .365-.5L8.5 2.586A2 2 0 0 1 9 2.22ZM11 2v5a2 2 0 0 1-2 2H4a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2 2 2 0 0 0 2 2h12a2 2 0 0 0 2-2 2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2V4a2 2 0 0 0-2-2h-7Zm-6 9a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h.5a2.5 2.5 0 0 0 0-5H5Zm1.5 3H6v-1h.5a.5.5 0 0 1 0 1Zm4.5-3a1 1 0 0 0-1 1v5a1 1 0 0 0 1 1h1.376A2.626 2.626 0 0 0 15 15.375v-1.75A2.626 2.626 0 0 0 12.375 11H11Zm1 5v-3h.375a.626.626 0 0 1 .625.626v1.748a.625.625 0 0 1-.626.626H12Zm5-5a1 1 0 0 0-1 1v5a1 1 0 1 0 2 0v-1h1a1 1 0 1 0 0-2h-1v-1h1a1 1 0 1 0 0-2h-2Z"
          clip-rule="evenodd"
        />
      </svg>
      Print To PDF
    </x-filament::button>
  </div>

  @if ($open_detail_modal)
    <div
      class="fixed top-0 right-0 left-0 z-50 grid h-[calc(100%-1rem)] max-h-full w-full items-center justify-center overflow-x-hidden overflow-y-auto md:inset-0"
    >
      <div class="relative max-h-full w-full max-w-2xl p-4">
        <!-- Modal content -->
        <div
          class="relative rounded-lg border bg-white shadow md:min-w-[40vw] dark:border-zinc-600 dark:bg-zinc-900"
        >
          <!-- Modal header -->
          <div
            class="flex items-center justify-between rounded-t border-b px-4 py-3 dark:border-zinc-600"
          >
            <h3 class="text-xl font-semibold text-gray-900 dark:text-white">
              Detail Pengerjaan
            </h3>
            <button
              wire:click="closeModal"
              type="button"
              class="ms-auto inline-flex h-8 w-8 items-center justify-center rounded-lg bg-transparent text-sm text-gray-400 hover:bg-gray-200 hover:text-gray-900 dark:hover:bg-gray-600 dark:hover:text-white"
              data-modal-hide="default-modal"
            >
              <svg
                class="h-3 w-3"
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
              <span class="sr-only">Close modal</span>
            </button>
          </div>
          <!-- Modal body -->
          <div class="space-y-4 p-4 md:p-5">
            <div class="flex justify-between">
              <p>Peringkat #{{ $activeRanking }}</p>
              <p>Nilai: {{ $activeStudentQuiz->score }} / 100</p>
            </div>
            <div class="grid grid-cols-2">
              <p>Nama</p>
              <p class="">: {{ $activeStudentQuiz->student->name }}</p>
              <p>Username</p>
              <p class="">: {{ $activeStudentQuiz->student->username }}</p>
              <p>Sekolah</p>
              <p class="">: {{ $activeStudentQuiz->student->school->name }}</p>
              <p>Jawaban Benar</p>
              <p class="text-nowrap">
                : {{ $correct_answer_count }} /
                {{ $activeStudentQuiz->quiz->questions->count() }}
              </p>
              <p>Jawaban Salah</p>
              <p class="text-nowrap">
                : {{ $wrong_answer_count }} /
                {{ $activeStudentQuiz->quiz->questions->count() }}
              </p>
              <p>Tidak Dijawab</p>
              <p class="text-nowrap">
                : {{ $not_answer_count }} /
                {{ $activeStudentQuiz->quiz->questions->count() }}
              </p>
              <p>Waktu Mulai</p>
              <p class="text-nowrap">
                :
                {{ date("d M Y H:i", strtotime($activeStudentQuiz->start_time)) }}
              </p>
              <p>Waktu Selesai</p>
              <p class="text-nowrap">
                :
                {{ date("d M Y H:i", strtotime($activeStudentQuiz->end_time)) }}
              </p>
              <p>Durasi Pengerjaan</p>
              <p class="text-nowrap">: {{ $duration }}</p>
            </div>
            <form action="" wire:submit="setScore">
              <div class="flex items-center justify-between gap-x-3">
                <p class="text-nowrap">Berikan Nilai</p>
                <input
                  wire:model="score"
                  type="number"
                  min="0"
                  max="100"
                  id="first_name"
                  class="w-full rounded border border-gray-300 bg-gray-50 p-2 text-xs text-gray-900 focus:border-blue-500 focus:ring-blue-500 dark:border-gray-600 dark:bg-zinc-700 dark:text-white dark:placeholder-gray-400 dark:focus:border-blue-500 dark:focus:ring-blue-500"
                  placeholder="Nilai 0-100"
                />
                <button
                  type="submit"
                  class="rounded bg-gray-800 px-5 py-1 text-sm font-medium text-white hover:bg-gray-900 focus:ring-4 focus:ring-gray-300 focus:outline-none dark:border-gray-700 dark:bg-zinc-800 dark:hover:bg-gray-700 dark:focus:ring-gray-700"
                >
                  Ubah
                </button>
              </div>
            </form>

            @if ($activeStudentQuiz->quiz->quiz_type_id == 3)
              <div class="grid gap-y-3">
                <a
                  href="{{ asset("storage/" . $essay_file) }}"
                  download
                  class="text-primary-600 hover:text-primary-500 dark:text-primary-400 dark:hover:text-primary-300 text-sm font-medium"
                >
                  Download PDF
                </a>
                <iframe
                  src="{{ asset("storage/" . $essay_file) }}"
                  width="100%"
                  height="600px"
                  class="rounded-lg border border-gray-200 bg-white dark:border-white/10 dark:bg-gray-900"
                ></iframe>
              </div>
            @endif
          </div>

          <div
            class="flex items-center justify-end rounded-b-lg border-t border-zinc-200 bg-gray-50 px-6 py-2 dark:border-white/10 dark:bg-zinc-900"
          >
            <x-filament::button
              wire:click="closeModal"
              type="button"
              color="gray"
              size="sm"
            >
              Tutup
            </x-filament::button>
          </div>
        </div>
      </div>
    </div>
  @endif
</div>
