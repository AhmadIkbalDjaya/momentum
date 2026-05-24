<nav class="fixed z-10 w-full bg-white px-5 py-1 text-white">
  <div class="flex items-center justify-between">
    <!-- Hamburger icon -->
    <button id="hamburger" class="focus:outline-none md:hidden">
      <x-icons.menu class="text-secondary" />
    </button>
    <!-- Admin Dashboard Title -->
    <a
      wire:navigate
      href="{{ route("home") }}"
      class="ml-0 grow md:ml-2 md:grow-0"
    >
      <img
        src="{{ asset("images/logo.webp") }}"
        alt=""
        srcset=""
        class="mx-auto h-12 object-cover"
      />
    </a>
    <!-- User Avatar -->
    <div class="relative">
      <div id="user-avatar" class="flex cursor-pointer items-center gap-1">
        <img
          id=""
          src="{{ asset("images/man.webp") }}"
          alt="User Avatar"
          class="bg-primary h-10 w-10 rounded-full"
        />
        <p class="text-secondary hidden text-sm font-medium md:block">
          {{ Auth::guard("student")->user()->name }}
        </p>
      </div>
      <div
        id="dropdown"
        class="absolute right-0 z-20 mt-2 hidden w-48 rounded-md bg-white py-2 shadow-lg"
      >
        <a
          wire:navigate
          href="{{ route("profile") }}"
          class="flex items-center gap-x-3 px-4 py-2 font-medium text-gray-800 hover:bg-gray-200"
        >
          <x-icons.user class="h-5 w-5" />
          Profile
        </a>
        <button
          wire:click="logout"
          class="flex w-full cursor-pointer items-center gap-x-3 px-4 py-2 font-medium text-gray-800 hover:bg-gray-200"
        >
          <x-icons.logout class="h-5 w-5" />
          Logout
        </button>
      </div>
    </div>
  </div>
</nav>
