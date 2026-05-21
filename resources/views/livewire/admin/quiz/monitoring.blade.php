<div wire:poll.3s="check_expire" class="space-y-5">
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
            <th class="fi-ta-header-cell">No</th>
            <th class="fi-ta-header-cell">Nama</th>
            <th class="fi-ta-header-cell">Sekolah</th>
            <th class="fi-ta-header-cell">Status</th>
            <th class="fi-ta-header-cell">Waktu tersisa</th>
            <th class="fi-ta-header-cell">Jawaban</th>
            <th class="fi-ta-header-cell">Status Pengerjaan</th>
          </tr>
        </thead>
        <tbody id="students-table-body">
          @foreach ($students as $student)
            <tr class="fi-ta-row">
              <td
                class="px-3 py-3 text-sm font-medium text-nowrap whitespace-nowrap text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $loop->iteration }}
              </td>
              <td
                class="px-3 py-3 text-sm font-medium whitespace-nowrap text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $student["name"] }}
              </td>
              <td
                class="max-w-35 overflow-hidden px-3 py-3 text-sm text-nowrap text-ellipsis text-gray-500 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-gray-400"
              >
                {{ $student["school_name"] }}
              </td>
              <td
                class="px-3 py-3 text-sm text-nowrap sm:first-of-type:ps-6 sm:last-of-type:pe-6"
              >
                @if ($student["status"] == "online")
                  <x-filament::badge color="success">Online</x-filament::badge>
                @else
                  <x-filament::badge color="danger">Offline</x-filament::badge>
                @endif
              </td>
              <td
                class="px-3 py-3 text-sm font-medium text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $student["time_remaining"] }}
              </td>
              <td
                class="px-3 py-3 text-sm font-medium text-gray-950 sm:first-of-type:ps-6 sm:last-of-type:pe-6 dark:text-white"
              >
                {{ $student["answer_count"] }} /
                {{ $quiz->questions->count() }}
              </td>
              <td
                class="px-3 py-3 text-sm font-medium sm:first-of-type:ps-6 sm:last-of-type:pe-6"
              >
                @if ($student["is_done"])
                  <x-filament::badge color="success" class="text-nowrap">
                    Selesai
                  </x-filament::badge>
                @elseif ($student["is_done"] === 0)
                  <x-filament::badge color="danger" class="text-nowrap">
                    Belum Selesai
                  </x-filament::badge>
                @elseif ($student["is_done"] === null)
                  <x-filament::badge color="gray" class="text-nowrap">
                    Belum Dikerjakan
                  </x-filament::badge>
                @endif
              </td>
            </tr>
          @endforeach
        </tbody>
      </table>
    </div>
  </div>
</div>
@assets
  @vite(["resources/js/app.js"])
@endassets
