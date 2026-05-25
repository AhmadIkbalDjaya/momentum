@props([
  "label" => null,
  "required" => false,
])

<label {{ $attributes->merge(["class" => "text-base text-gray-500 w-fit"]) }}>
  {{ $label }}
  @if ($required)
    <span class="text-red-500">*</span>
  @endif
</label>
