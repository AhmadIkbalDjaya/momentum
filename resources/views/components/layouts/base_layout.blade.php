<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <script
      src="https://kit.fontawesome.com/0d8b715e25.js"
      crossorigin="anonymous"
    ></script>
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
    <div id="app" class="flex min-h-screen flex-col bg-gray-100">
      <!-- Navbar -->
      <livewire:user.components.header />

      <div class="flex min-h-screen flex-1">
        <!-- Sidebar -->
        <livewire:user.components.sidebar />

        <!-- Main content -->
        <main
          id="main-content"
          class="mt-14 w-full flex-1 p-6 md:ml-64 md:w-auto"
        >
          {{ $slot }}
        </main>
      </div>
    </div>

    @stack("script")
    <script>
      function initializeScripts() {
        const hamburger = document.getElementById('hamburger');
        const sidebar = document.getElementById('sidebar');
        const userAvatar = document.getElementById('user-avatar');
        const dropdown = document.getElementById('dropdown');

        if (hamburger && sidebar) {
          hamburger.addEventListener('click', function () {
            sidebar.classList.toggle('hidden');
          });
        }

        if (userAvatar && dropdown) {
          userAvatar.addEventListener('click', function () {
            dropdown.classList.toggle('hidden');
          });

          document.addEventListener('click', function (event) {
            if (
              !userAvatar.contains(event.target) &&
              !dropdown.contains(event.target)
            ) {
              dropdown.classList.add('hidden');
            }
          });
        }
      }

      // Initial run
      initializeScripts();
    </script>
  </body>
</html>
