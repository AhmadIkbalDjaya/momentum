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

  <div class="rounded-lg bg-white p-6 shadow-sm">
    <div class="flex flex-wrap gap-x-2 gap-y-3 md:flex-nowrap md:gap-x-6">
      <div class="basis-full md:basis-auto">
        <img
          src="{{ asset("images/man2.webp") }}"
          alt=""
          srcset=""
          class="bg-primary rounded-lg md:h-36"
        />
      </div>
      <div class="flex flex-col justify-around md:grow md:py-0">
        <div class="">
          <h6 class="text-primary text-xl font-medium">
            {{ $auth["name"] }}
          </h6>
          <p class="text-sm font-medium text-gray-400">
            {{ $auth["username"] }}
          </p>
          <p class="text-sm font-medium text-gray-400">
            Asal Sekolah : {{ $auth["school"] }}
          </p>
          <p class="text-sm font-medium text-gray-400">
            Jenis Kelamin: {{ $auth["gender"] }}
          </p>
        </div>
        <div
          class="mt-3 flex flex-wrap gap-x-2 gap-y-3 md:mt-0 md:flex-nowrap md:gap-x-8"
        >
          <div class="flex items-center gap-3">
            <div class="grid place-items-center rounded p-2 shadow">
              <x-icons.flag class="text-primary h-5 w-5" />
            </div>
            <div class="flex items-center gap-x-1 md:flex-col md:items-start">
              <h6 class="text-xs font-bold text-gray-400 md:text-lg">
                {{ $auth["quiz_count"] }}
              </h6>
              <p class="text-xs text-gray-400">Quiz Diselesaikan</p>
            </div>
          </div>
          <div class="flex items-center gap-3">
            <div class="grid place-items-center rounded p-2 shadow">
              <x-icons.circle-check class="text-primary h-5 w-5" />
            </div>
            <div class="flex items-center gap-x-1 md:flex-col md:items-start">
              <h6 class="text-xs font-bold text-gray-400 md:text-lg">
                {{ $auth["answer_count"] }}
              </h6>
              <p class="text-xs text-gray-400">Soal Dijawab</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div class="rounded-lg bg-white p-6 shadow-sm">
    <h1 class="text-primary font-bold">Ganti Password</h1>
    @if (flash()->message)
      <p class="text-sm text-red-400">{{ flash()->message }}</p>
    @endif

    <form action="" wire:submit="changePassword">
      <div class="mt-4 mb-2 flex flex-col gap-y-2">
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
          class="form-input md:w-1/2"
        />
        <x-input-error-message name="current_password" />
      </div>
      <div class="mt-4 mb-2 flex flex-col gap-y-2">
        <x-input-label label="Password Baru" required for="new_password" />
        <input
          type="password"
          wire:model="new_password"
          name="new_password"
          id="new_password"
          placeholder="Masukkan Password Baru"
          class="form-input md:w-1/2"
        />
        <x-input-error-message name="new_password" />
      </div>
      <div class="mt-4 mb-2 flex flex-col gap-y-2">
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
          class="form-input md:w-1/2"
        />
        <x-input-error-message name="new_password_confirmation" />
      </div>
      <button type="submit" class="btn btn-primary mt-3 w-full md:w-1/2">
        <x-loading-icon target="changePassword" />
        Ganti password
      </button>
    </form>
  </div>
</div>
