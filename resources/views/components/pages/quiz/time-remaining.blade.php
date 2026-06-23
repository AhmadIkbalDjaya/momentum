<div x-data="timeRemaining" class="rounded-lg bg-white p-6 shadow-sm">
  <h6 class="mb-3 font-semibold text-gray-700">Waktu Tersisa</h6>
  <div class="flex items-center gap-5">
    <x-icons.clock-hour-4 class="text-primary h-10 w-10" />
    <p
      x-bind:class="remainingTime == 'Waktu Habis' ? 'text-2xl' : 'text-5xl'"
      class="text-primary font-bold"
      x-text="remainingTime"
    ></p>
  </div>
  <div class="bg-primary/15 mt-5 h-2 overflow-hidden rounded-full">
    <div
      class="bg-primary h-full rounded-full transition-all"
      x-bind:style="`width: ${remainingPercent}%`"
    ></div>
  </div>
</div>
