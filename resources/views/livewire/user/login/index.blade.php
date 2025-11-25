<div class="flex h-screen">
  {{-- In work, do what you enjoy. --}}
  <div
    class="hidden basis-6/12 bg-cover bg-center bg-no-repeat md:block"
    style="background-image: url('{{ asset("images/login-bg.webp") }}')"
  >
    <div
      class="grid h-full w-full place-items-center bg-[#14929a]/[.65] backdrop-blur-sm"
    >
      <div class="w-6/12 px-2 text-white">
        <i class="fa-solid fa-quote-left pb-5 text-[#21415a]"></i>
        <p class="ps-2 text-base">
          {{ $quote["quote"] }}
        </p>
        <p class="pt-8 text-lg font-medium">{{ $quote["name"] }}</p>
        <p class="text-end">
          <i
            class="fa-solid fa-angle-up rotate-[135deg] text-4xl font-black"
          ></i>
        </p>
      </div>
    </div>
  </div>
  <div class="flex basis-full flex-col md:basis-6/12">
    <div class="hidden px-12 pt-2 md:block">
      <img
        src="{{ asset("images/logo.webp") }}"
        alt=""
        srcset=""
        class="h-20"
      />
    </div>
    <div class="grid grow place-items-center">
      <div class="w-96 px-2 md:w-6/12 md:py-5">
        <div class="pb-20 md:hidden">
          <img
            src="{{ asset("images/logo.webp") }}"
            alt=""
            srcset=""
            class="mx-auto h-20"
          />
        </div>
        <h6 class="text-xl font-bold text-primary">Login to your Account</h6>
        @if (flash()->message)
          <p class="text-sm text-red-400">{{ flash()->message }}</p>
        @endif

        <form action="" wire:submit="login">
          <div class="mb-2 mt-4 flex flex-col gap-y-2">
            <label for="username" class="text-base text-gray-500">
              Username*
            </label>
            <input
              type="text"
              wire:model="username"
              name="username"
              id="username"
              placeholder="Enter username"
              class="rounded-md px-5 py-2 placeholder-primary shadow-[0px_5px_6px_0px_rgba(0,0,0,0.06)] focus:outline-primary"
            />
            @error("username")
              <livewire:components.input-error-message field="username" />
            @enderror
          </div>
          <div class="mb-5 flex flex-col gap-y-2">
            <label for="password" class="text-base text-gray-500">
              Password*
            </label>
            <input
              type="password"
              wire:model="password"
              name="password"
              id="password"
              placeholder="Enter password"
              class="rounded-md px-5 py-2 placeholder-primary shadow-[0px_5px_6px_0px_rgba(0,0,0,0.06)] focus:outline-primary"
            />
            @error("password")
              <livewire:components.input-error-message field="password" />
            @enderror
          </div>
          <div>
            <button
              type="submit"
              class="flex w-full items-center justify-center gap-x-1 rounded-lg bg-primary px-5 py-2 font-medium text-white"
            >
              <x-loading-icon />
              Login
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</div>
