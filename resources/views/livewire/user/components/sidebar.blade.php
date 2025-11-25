<aside
  id="sidebar"
  class="fixed bottom-0 top-14 z-10 hidden w-64 space-y-6 bg-white p-6 text-white md:block"
>
  <nav class="flex h-full flex-col justify-between space-y-4">
    <div class="flex flex-col gap-y-3">
      <a
        wire:navigate
        href="{{ route("home") }}"
        class="{{ Request::is("/") ? "bg-primary text-white" : "text-gray-500" }} flex items-center gap-3 rounded px-4 py-2.5 font-medium transition duration-200 hover:bg-primary hover:text-white"
      >
        <i class="fa-solid fa-house"></i>
        <span class="">Home</span>
      </a>
      <a
        wire:navigate
        href="{{ route("quiz.index") }}"
        class="{{ Request::is("quiz*") && ! Request::is("quiz/history") ? "bg-primary text-white" : "text-gray-500" }} flex items-center gap-3 rounded px-4 py-2.5 font-medium transition duration-200 hover:bg-primary hover:text-white"
      >
        <i class="fa-solid fa-pen-to-square"></i>
        <span class="">Quiz</span>
      </a>
      <a
        wire:navigate
        href="{{ route("quiz.history") }}"
        class="{{ Request::is("quiz/history*") ? "bg-primary text-white" : "text-gray-500" }} flex items-center gap-3 rounded px-4 py-2.5 font-medium transition duration-200 hover:bg-primary hover:text-white"
      >
        <i class="fa-solid fa-clock-rotate-left"></i>
        <span class="">Quiz History</span>
      </a>
    </div>
    <div class="flex flex-col gap-y-4">
      <div class="rounded-xl bg-primary px-4 pb-4 pt-4 text-center text-white">
        <img
          id=""
          src="{{ asset("images/man.webp") }}"
          alt="User Avatar"
          class="mx-auto mb-3 h-20 w-20 rounded-full bg-white"
        />
        <p class="font-medium">{{ Auth::guard("student")->user()->name }}</p>
        <p class="text-sm">{{ Auth::guard("student")->user()->username }}</p>
        <div class="flex justify-center gap-x-1.5">
          <a
            wire:navigate
            href="{{ route("profile") }}"
            type="button"
            class="rounded bg-white px-3 py-0.5 text-center text-xs font-medium text-primary"
          >
            Profile
          </a>
          <button
            wire:click="logout"
            type="button"
            class="rounded bg-white px-3 py-0.5 text-center text-xs font-medium text-primary"
          >
            Logout
          </button>
        </div>
      </div>
    </div>
  </nav>
</aside>
