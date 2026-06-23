<div class="w-full max-w-md">
  <div class="mb-8 text-center">
    <img
      src="{{ asset("images/logo.webp") }}"
      alt="{{ config("app.name") }}"
      srcset=""
      class="mx-auto h-20"
    />
  </div>

  <div class="rounded-xl bg-white p-5 shadow-sm ring-1 ring-gray-100 sm:p-6">
    <div>
      <p class="text-primary text-xs font-bold uppercase">Login Siswa</p>
      <h1 class="mt-1 text-2xl font-bold text-gray-800">Masuk ke Akun Anda</h1>
      <p class="mt-2 text-sm font-medium text-gray-500">
        Gunakan username dan password siswa untuk melanjutkan.
      </p>
    </div>

    @if (flash()->message)
      <div
        class="mt-4 rounded-lg bg-red-500/10 px-4 py-3 text-sm font-medium text-red-500"
      >
        {{ flash()->message }}
      </div>
    @endif

    <form action="" wire:submit="login" class="mt-5 space-y-4">
      <div class="flex flex-col gap-y-2">
        <x-input-label label="Username" required for="username" />
        <div class="relative">
          <x-icons.user
            class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-gray-400"
          />
          <input
            type="text"
            wire:model="username"
            name="username"
            id="username"
            placeholder="Masukkan username"
            autocomplete="username"
            class="form-input w-full ps-10"
          />
        </div>
        <x-input-error-message name="username" />
      </div>

      <div class="flex flex-col gap-y-2">
        <x-input-label label="Password" required for="password" />
        <div class="relative">
          <x-icons.lock
            class="absolute top-1/2 left-3 h-4 w-4 -translate-y-1/2 text-gray-400"
          />
          <input
            type="password"
            wire:model="password"
            name="password"
            id="password"
            placeholder="Masukkan password"
            autocomplete="current-password"
            class="form-input w-full ps-10"
          />
        </div>
        <x-input-error-message name="password" />
      </div>

      <button type="submit" class="btn btn-primary btn-full rounded-md py-2.5">
        <x-loading-icon target="login" />
        Masuk
      </button>
    </form>
  </div>

  <p class="mt-6 text-center text-xs font-medium text-gray-400">
    {{ config("app.name") }} &copy; {{ date("Y") }}
  </p>
</div>
