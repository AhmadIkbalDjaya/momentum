@props([
  "quote" => null,
])

<div
  class="relative hidden overflow-hidden bg-cover bg-center bg-no-repeat md:block"
  style="background-image: url('{{ asset("images/login-bg.webp") }}')"
>
  <div
    class="bg-primary/70 relative grid h-full place-items-center p-10 text-white backdrop-blur-sm"
  >
    <div class="relative max-w-md -translate-y-8">
      <x-icons.quote-left class="mb-5 h-8 w-8 text-white/80" />
      <p class="text-lg leading-relaxed font-medium">
        {{ $quote["quote"] }}
      </p>
      <p class="mt-6 text-base font-bold">{{ $quote["name"] }}</p>
    </div>

    <div
      class="absolute bottom-10 left-10 flex items-center gap-3 text-sm font-medium text-white/80"
    >
      <span class="h-2 w-2 rounded-full bg-white"></span>
      <span>Belajar lebih terarah, hasil lebih terukur.</span>
    </div>
  </div>
</div>
