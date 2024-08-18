<div class="flex flex-col gap-y-3">
  <nav
    class="w-full rounded-md bg-gray-100 px-3 pb-1 pt-0 font-normal text-gray-500"
  >
    <ol class="list-reset flex">
      <li>
        <a
          wire:navigate
          href="{{ route("home") }}"
          class="text-nowrap text-gray-500"
        >
          Home
        </a>
      </li>
      <li>
        <span class="mx-2">/</span>
      </li>
      <li>
        <a class="text-nowrap text-gray-500">Profile</a>
      </li>
    </ol>
  </nav>
  <div class="rounded-lg bg-white p-6 shadow-sm">
    <div class="flex flex-wrap gap-x-2 gap-y-3 md:flex-nowrap md:gap-x-6">
      <div class="basis-full md:basis-auto">
        <img
          src="{{ asset("images/man2.webp") }}"
          alt=""
          srcset=""
          class="rounded-lg bg-momentum1 md:h-36"
        />
      </div>
      <div class="flex flex-col justify-around md:grow md:py-0">
        <div class="">
          <h6 class="text-xl font-medium text-momentum1">
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
          <div class="flex gap-3">
            <div class="grid place-items-center rounded px-3 py-2 shadow">
              <i class="fa-solid fa-flag text-lg text-momentum1"></i>
            </div>
            <div class="flex items-center gap-x-1 md:flex-col md:items-start">
              <h6 class="text-xs font-bold text-gray-400 md:text-lg">
                {{ $auth["quiz_count"] }}
              </h6>
              <p class="text-xs text-gray-400">Quiz Diselesaikan</p>
            </div>
          </div>
          <div class="flex gap-3">
            <div class="grid place-items-center rounded px-3 py-2 shadow">
              <i class="fa-solid fa-circle-check text-lg text-momentum1"></i>
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
    <h1 class="font-bold text-momentum1">Ganti Password</h1>
    @if (flash()->message)
      <p class="text-sm text-red-400">{{ flash()->message }}</p>
    @endif

    <form action="" wire:submit="changePassword">
      <div class="mb-2 mt-4 flex flex-col gap-y-2">
        <label for="password_old" class="text-base text-gray-500">
          Password Saat Ini*
        </label>
        <input
          type="password"
          wire:model="current_password"
          name="current_password"
          id="current_password"
          placeholder="Masukkan Password Saat Ini"
          class="shadow-[0px_5px_6p x_0px_rgba(0,0,0,0.06)] rounded-md px-5 py-2 placeholder-momentum1 focus:outline-momentum1 md:w-1/2"
        />
        @error("current_password")
          <livewire:components.input-error-message field="current_password" />
        @enderror
      </div>
      <div class="mb-2 mt-4 flex flex-col gap-y-2">
        <label for="new_password" class="text-base text-gray-500">
          Password Baru*
        </label>
        <input
          type="password"
          wire:model="new_password"
          name="new_password"
          id="new_password"
          placeholder="Masukkan Password Baru"
          class="rounded-md px-5 py-2 placeholder-momentum1 shadow-[0px_5px_6px_0px_rgba(0,0,0,0.06)] focus:outline-momentum1 md:w-1/2"
        />
        @error("new_password")
          <livewire:components.input-error-message field="new_password" />
        @enderror
      </div>
      <div class="mb-2 mt-4 flex flex-col gap-y-2">
        <label for="new_password_confirmation" class="text-base text-gray-500">
          Konfirmasi Password Baru*
        </label>
        <input
          type="password"
          wire:model="new_password_confirmation"
          name="new_password_confirmation"
          id="new_password_confirmation"
          placeholder="Masukkan Konfirmasi Password Baru"
          class="rounded-md px-5 py-2 placeholder-momentum1 shadow-[0px_5px_6px_0px_rgba(0,0,0,0.06)] focus:outline-momentum1 md:w-1/2"
        />
        @error("new_password_confirmation")
          <livewire:components.input-error-message
            field="new_password_confirmation"
          />
        @enderror
      </div>
      <button
        type="submit"
        class="mt-3 w-full rounded-lg bg-momentum1 px-5 py-2 font-medium text-white md:w-1/2"
      >
        Ganti password
      </button>
    </form>
  </div>
</div>
