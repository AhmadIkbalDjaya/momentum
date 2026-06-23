@props([
  "auth" => null,
])

<div class="overflow-hidden rounded-lg bg-white shadow-sm">
  <div
    class="flex flex-col gap-5 p-5 md:flex-row md:items-center md:justify-between"
  >
    <div class="flex min-w-0 items-center gap-4">
      <img
        src="{{ asset("images/man2.webp") }}"
        alt="{{ $auth["name"] }}"
        srcset=""
        class="bg-primary h-20 w-20 shrink-0 rounded-lg object-cover md:h-28 md:w-28"
      />
      <div class="min-w-0">
        <p class="text-xs font-bold text-gray-400 uppercase">Profil Siswa</p>
        <h6 class="text-primary mt-1 truncate text-xl font-bold md:text-2xl">
          {{ $auth["name"] }}
        </h6>
        <div class="mt-2 flex flex-wrap gap-2">
          <span
            class="bg-primary/10 text-primary rounded-full px-3 py-1 text-xs font-bold"
          >
            {{ $auth["username"] }}
          </span>
          <span
            class="rounded-full bg-gray-100 px-3 py-1 text-xs font-bold text-gray-600"
          >
            {{ $auth["gender"] }}
          </span>
        </div>
        <p class="mt-3 truncate text-sm font-medium text-gray-500">
          {{ $auth["school"] }}
        </p>
      </div>
    </div>

    <div class="grid grid-cols-1 gap-2 sm:grid-cols-2 md:min-w-80">
      <div
        class="flex items-center gap-3 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2.5"
      >
        <div
          class="text-primary bg-primary/10 grid h-9 w-9 shrink-0 place-items-center rounded-md"
        >
          <x-icons.flag class="h-5 w-5" />
        </div>
        <div class="min-w-0">
          <h6 class="text-primary text-xl leading-none font-bold">
            {{ $auth["quiz_count"] }}
          </h6>
          <p class="mt-1 truncate text-xs font-medium text-gray-500">
            Quiz Diselesaikan
          </p>
        </div>
      </div>
      <div
        class="flex items-center gap-3 rounded-lg border border-gray-100 bg-gray-50 px-3 py-2.5"
      >
        <div
          class="text-primary bg-primary/10 grid h-9 w-9 shrink-0 place-items-center rounded-md"
        >
          <x-icons.circle-check class="h-5 w-5" />
        </div>
        <div class="min-w-0">
          <h6 class="text-primary text-xl leading-none font-bold">
            {{ $auth["answer_count"] }}
          </h6>
          <p class="mt-1 truncate text-xs font-medium text-gray-500">
            Soal Dijawab
          </p>
        </div>
      </div>
    </div>
  </div>
</div>
