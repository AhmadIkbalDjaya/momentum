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
