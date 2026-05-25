@props([
  "name" => null,
])

@error($name)
  <span {{ $attributes->merge(["class" => "text-xs text-red-500"]) }}>
    {{ $message }}
  </span>
@enderror
