<div wire:poll.3s="check_expire">
  <div class="w-full rounded-lg bg-white p-6 shadow dark:bg-zinc-900">
    <div class="flex flex-col-reverse md:flex-row">
      <div class="grid basis-12/12 grid-cols-2 gap-y-2 md:basis-8/12">
        <p>Nama</p>
        <p class="">: {{ $quiz->name }}</p>
        <p>Kode</p>
        <p class="">: {{ $quiz->code }}</p>
        <p>Jenis Sekolah</p>
        <p class="">: {{ $quiz->school_category->name }}</p>
        <p>Jenis Kuis</p>
        <p class="">: {{ $quiz->quiz_type->description }}</p>
        <p>Waktu Mulai</p>
        <p class="">: {{ date("d M Y H:i", strtotime($quiz->start_time)) }}</p>
        <p>Waktu Selesai</p>
        <p class="">: {{ date("d M Y H:i", strtotime($quiz->end_time)) }}</p>
        <p>Durasi Pengerjaan</p>
        <p class="">: {{ $quiz->duration }} Menit</p>
      </div>
      <div class="mx-10 basis-12/12 md:mx-0 md:basis-3/12">
        <img
          src="{{ asset("images/icons/quiz.webp") }}"
          alt=""
          srcset=""
          class=""
        />
      </div>
    </div>
  </div>

  <div class="relative mt-5 overflow-x-auto rounded-lg">
    <table class="w-full text-left text-sm text-gray-500 dark:text-gray-400">
      <thead
        class="bg-gray-50 text-xs text-gray-700 uppercase dark:bg-gray-700 dark:text-gray-400"
      >
        <tr>
          <th class="px-6 py-3">No</th>
          <th class="px-6 py-3">Nama</th>
          <th class="px-6 py-3">Sekolah</th>
          <th class="px-6 py-3">Status</th>
          <th class="px-6 py-3">Waktu tersisa</th>
          <th class="px-6 py-3">Jawaban</th>
          <th class="px-6 py-3">Status Pengerjaan</th>
        </tr>
      </thead>
      <tbody id="students-table-body">
        @foreach ($students as $student)
          <tr class="border-b bg-white dark:border-gray-700 dark:bg-gray-800">
            <td
              class="px-6 py-2 font-medium text-nowrap whitespace-nowrap text-gray-900 dark:text-white"
            >
              {{ $loop->iteration }}
            </td>
            <td
              class="px-6 py-2 font-medium whitespace-nowrap text-gray-900 dark:text-white"
            >
              {{ $student["name"] }}
            </td>
            <td class="px-6 py-2 text-nowrap">
              {{ $student["school_name"] }}
            </td>
            <td class="px-6 py-2 text-nowrap">
              @if ($student["status"] == "online")
                <span
                  class="me-2 rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-green-800 dark:bg-green-900 dark:text-green-300"
                >
                  Online
                </span>
              @else
                <span
                  class="me-2 rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-red-800 dark:bg-red-900 dark:text-red-300"
                >
                  Offline
                </span>
              @endif
            </td>
            <td class="px-6 py-2 font-medium">
              {{ $student["time_remaining"] }}
            </td>
            <td class="px-6 py-2 font-medium">
              {{ $student["answer_count"] }} / {{ $quiz->questions->count() }}
            </td>
            <td class="px-6 py-2 font-medium">
              @if ($student["is_done"])
                <span
                  class="me-2 rounded bg-green-100 px-2.5 py-0.5 text-xs font-medium text-nowrap text-green-800 dark:bg-green-900 dark:text-green-300"
                >
                  Selesai
                </span>
              @elseif ($student["is_done"] === 0)
                <span
                  class="me-2 rounded bg-red-100 px-2.5 py-0.5 text-xs font-medium text-nowrap text-red-800 dark:bg-red-900 dark:text-red-300"
                >
                  Belum Selesai
                </span>
              @elseif ($student["is_done"] === null)
                <span
                  class="me-2 rounded bg-gray-100 px-2.5 py-0.5 text-xs font-medium text-nowrap text-gray-800 dark:bg-gray-900 dark:text-gray-300"
                >
                  Belum Dikerjakan
                </span>
              @endif
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>
@assets
  @vite(["resources/js/app.js"])
@endassets
