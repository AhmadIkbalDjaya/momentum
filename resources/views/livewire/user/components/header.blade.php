<nav class="fixed z-10 w-full bg-white px-5 py-1 text-white">
  <div class="container mx-auto flex items-center justify-between">
    <!-- Hamburger icon -->
    <button id="hamburger" class="focus:outline-none md:hidden">
      <svg
        class="text-secondary h-6 w-6"
        fill="none"
        stroke="currentColor"
        viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg"
      >
        <path
          stroke-linecap="round"
          stroke-linejoin="round"
          stroke-width="2"
          d="M4 6h16M4 12h16M4 18h16"
        ></path>
      </svg>
    </button>
    <!-- Admin Dashboard Title -->
    {{-- <div class="text-lg font-semibold flex-grow text-center md:flex-grow-0">Admin Dashboard</div> --}}
    <a
      wire:navigate
      href="{{ route("home") }}"
      class="ml-0 flex-grow md:ml-2 md:flex-grow-0"
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
          <i class="fa-solid fa-user"></i>
          Profile
        </a>
        <button
          wire:click="logout"
          class="flex w-full items-center gap-x-3 px-4 py-2 font-medium text-gray-800 hover:bg-gray-200"
        >
          <i class="fa-solid fa-right-from-bracket"></i>
          Logout
        </button>
      </div>
    </div>
  </div>
</nav>
