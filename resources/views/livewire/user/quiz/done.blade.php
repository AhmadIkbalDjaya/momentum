<div>
  <div class="min-h-full rounded-lg bg-white p-6 text-center shadow-sm">
    <h6 class="text-primary text-lg font-bold">Quiz Telah Selesai</h6>
    <img
      src="{{ asset("images/icons/check.webp") }}"
      alt=""
      srcset=""
      class="mx-auto h-56 py-5"
    />
    <a
      wire:navigate
      href="{{ route("quiz.history") }}"
      class="btn btn-primary rounded px-3 py-1 text-lg"
    >
      Lihat history quiz
    </a>
  </div>
</div>
