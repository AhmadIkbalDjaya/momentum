<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link
      rel="icon"
      href="{{ asset("images/web-logo.webp") }}"
      sizes="32x32"
    />
    <link
      rel="icon"
      href="{{ asset("images/web-logo.webp") }}"
      sizes="192x192"
    />
    <link rel="apple-touch-icon" href="{{ asset("images/web-logo.webp") }}" />
    <title>
      @isset($title) {{ $title . " - " . config("app.name") }}
       @else
      {{ config("app.name") }} @endisset
    </title>
    @vite(["resources/css/app.css", "resources/js/app.js"])
    @stack("style")
  </head>

  <body>
    {{ $slot }}
    @stack("script")
  </body>
</html>
