<nav class="bg-white text-white px-5 py-1">
  <div class="container mx-auto flex justify-between items-center">
    <!-- Hamburger icon -->
    <button id="hamburger" class="md:hidden focus:outline-none">
      <svg class="w-6 h-6 text-momentum2" fill="none" stroke="currentColor" viewBox="0 0 24 24"
        xmlns="http://www.w3.org/2000/svg">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
      </svg>
    </button>
    <!-- Admin Dashboard Title -->
    {{-- <div class="text-lg font-semibold flex-grow text-center md:flex-grow-0">Admin Dashboard</div> --}}
    <div class="flex-grow md:flex-grow-0">
      <img src="{{ asset('images/logo.png') }}" alt="" srcset="" class="object-cover h-12 mx-auto">
    </div>
    <!-- User Avatar -->
    <div class="relative">
      <div id="user-avatar" class="flex items-center gap-1 cursor-pointer">
        <img id="" src="{{ asset('images/man.png') }}" alt="User Avatar"
          class="w-10 h-10 rounded-full bg-momentum1">
        <p class="text-momentum2 text-sm font-medium hidden md:block">Ahmad Ikbal Djaya</p>
      </div>
      <div id="dropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-2 z-20">
        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Profile</a>
        <a href="#" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">Logout</a>
      </div>
    </div>
  </div>
</nav>