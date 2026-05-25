<div class="flex h-screen">
  <div
    class="hidden basis-6/12 bg-cover bg-center bg-no-repeat md:block"
    style="background-image: url('{{ asset("images/login-bg.webp") }}')"
  >
    <div
      class="bg-primary/65 grid h-full w-full place-items-center backdrop-blur-sm"
    >
      <div class="relative w-6/12 px-2 text-white">
        <x-icons.quote-left
          class="absolute -top-12 -left-1.5 h-7.5 w-7.5 text-[#21415a]!"
        />
        <p class="ps-2 text-base">
          {{ $quote["quote"] }}
        </p>
        <p class="pt-8 text-lg font-medium">{{ $quote["name"] }}</p>
        <p class="text-end">
          <x-icons.angle-up
            class="absolute -right-2 -bottom-6 h-10 w-10 rotate-135 font-black"
          />
        </p>
      </div>
    </div>
  </div>
  <div class="flex basis-full flex-col md:basis-6/12">
    <div class="hidden px-12 pt-2 md:block">
      <img
        src="{{ asset("images/logo.webp") }}"
        alt="{{ config("app.name") }}"
        srcset=""
        class="h-20"
      />
    </div>
    <div class="grid grow place-items-center">
      <div class="w-96 px-2 md:w-6/12 md:py-5">
        <div class="pb-20 md:hidden">
          <img
            src="{{ asset("images/logo.webp") }}"
            alt="{{ config("app.name") }}"
            srcset=""
            class="mx-auto h-20"
          />
        </div>
        <h6 class="text-primary text-xl font-bold">Login to your Account</h6>
        @if (flash()->message)
          <p class="text-sm text-red-400">{{ flash()->message }}</p>
        @endif

        <form action="" wire:submit="login">
          <div class="mt-4 mb-2 flex flex-col gap-y-2">
            <x-input-label label="Username" required for="username" />
            <input
              type="text"
              wire:model="username"
              name="username"
              id="username"
              placeholder="Enter username"
              class="form-input"
            />
            <x-input-error-message name="username" />
          </div>
          <div class="mb-5 flex flex-col gap-y-2">
            <x-input-label label="Password" required for="password" />
            <input
              type="password"
              wire:model="password"
              name="password"
              id="password"
              placeholder="Enter password"
              class="form-input"
            />
            <x-input-error-message name="password" />
          </div>
          <div>
            <button type="submit" class="btn btn-primary btn-full">
              <x-loading-icon />
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
