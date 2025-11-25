@props([
  "items" => [],
])

<nav
  class="w-full rounded-md bg-gray-100 px-3 pb-3 pt-0 font-normal text-gray-500"
>
  <ol class="list-reset flex">
    <li>
      <a
        wire:navigate
        href="{{ route("home") }}"
        class="text-nowrap text-gray-500"
      >
        Home
      </a>
    </li>
    @foreach ($items as $item)
      <li class="flex flex-nowrap">
        <span class="me-1 ms-2">/</span>
        <a
          wire:navigate
          @if (!$loop->last && $item['route'] != '') href="{{ route($item['route'], $item['params'] ?? []) }}" @endif
          class="text-nowrap text-gray-500"
        >
          {{ $item["name"] }}
        </a>
      </li>
    @endforeach
  </ol>
</nav>
