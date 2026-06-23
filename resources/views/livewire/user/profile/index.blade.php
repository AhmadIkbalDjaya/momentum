@php
  $breadcrumbs = [
    [
      "name" => "Profile",
      "route" => "",
    ],
  ];
@endphp

<div class="flex flex-col gap-y-3">
  <x-breadcrumb :items="$breadcrumbs" />

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

  <div class="rounded-lg bg-white shadow-sm">
    <div class="border-b border-gray-100 px-5 py-4">
      <div class="text-primary flex items-center gap-x-2">
        <x-icons.lock class="h-5 w-5" />
        <h1 class="font-bold">Ganti Password</h1>
      </div>
      <p class="mt-1 text-sm font-medium text-gray-500">
        Gunakan password baru minimal 8 karakter.
      </p>
    </div>

    <div class="p-5">
      @if (flash()->message)
        <div
          class="bg-primary/10 text-primary mb-4 rounded-lg px-4 py-3 text-sm font-medium"
        >
          {{ flash()->message }}
        </div>
      @endif

      <form
        action=""
        wire:submit="changePassword"
        class="grid gap-4 md:max-w-2xl"
      >
        <div class="flex flex-col gap-y-2">
          <x-input-label
            label="Password Saat Ini"
            required
            for="current_password"
          />
          <input
            type="password"
            wire:model="current_password"
            name="current_password"
            id="current_password"
            placeholder="Masukkan Password Saat Ini"
            class="form-input w-full"
          />
          <x-input-error-message name="current_password" />
        </div>
        <div class="flex flex-col gap-y-2">
          <x-input-label label="Password Baru" required for="new_password" />
          <input
            type="password"
            wire:model="new_password"
            name="new_password"
            id="new_password"
            placeholder="Masukkan Password Baru"
            class="form-input w-full"
          />
          <x-input-error-message name="new_password" />
        </div>
        <div class="flex flex-col gap-y-2">
          <x-input-label
            label="Konfirmasi Password Baru"
            required
            for="new_password_confirmation"
          />
          <input
            type="password"
            wire:model="new_password_confirmation"
            name="new_password_confirmation"
            id="new_password_confirmation"
            placeholder="Masukkan Konfirmasi Password Baru"
            class="form-input w-full"
          />
          <x-input-error-message name="new_password_confirmation" />
        </div>
        <button
          type="submit"
          class="btn btn-primary mt-1 w-full rounded-md md:w-fit"
        >
          <x-loading-icon target="changePassword" />
          Simpan Password Baru
        </button>
      </form>
    </div>
  </div>
</div>
