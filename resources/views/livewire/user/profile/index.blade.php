@php
  $breadcrumbs = [
    [
      "name" => "Profile",
      "route" => "",
    ],
  ];
@endphp

<div class="flex flex-col gap-y-3">
  <x-breadcrumb :items="$breadcrumbs" />

  <x-pages.profile.profile-card :auth="$auth" />

  <x-pages.profile.change-password />
</div>
