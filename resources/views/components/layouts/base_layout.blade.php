<!doctype html>
<html>

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://kit.fontawesome.com/0d8b715e25.js" crossorigin="anonymous"></script>
  <link rel="icon" href="{{ asset('images/web-logo.png') }}" sizes="32x32">
  <link rel="icon" href="{{ asset('images/web-logo.png') }}" sizes="192x192">
  <link rel="apple-touch-icon" href="{{ asset('images/web-logo.png') }}">
  <title>
    @isset($title)
      {{ $title . ' - ' . config('app.name') }}
    @else
      {{ config('app.name') }}
    @endisset
  </title>
  @vite('resources/css/app.css')
  @stack('style')
</head>

<body>
  <div id="app" class="min-h-screen flex flex-col bg-gray-100">
    <!-- Navbar -->
    <livewire:user.components.header />

    <div class="flex flex-1 min-h-screen">
      <!-- Sidebar -->
      <livewire:user.components.sidebar />

      <!-- Main content -->
      <main id="main-content" class="flex-1 p-6 w-full md:w-auto mt-14 md:ml-64">
        {{ $slot }}
      </main>
    </div>
  </div>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      const hamburger = document.getElementById('hamburger');
      const sidebar = document.getElementById('sidebar');
      const userAvatar = document.getElementById('user-avatar');
      const dropdown = document.getElementById('dropdown');

      hamburger.addEventListener('click', function() {
        sidebar.classList.toggle('hidden');
      });

      userAvatar.addEventListener('click', function() {
        dropdown.classList.toggle('hidden');
      });

      // Close the dropdown if clicked outside
      document.addEventListener('click', function(event) {
        if (!userAvatar.contains(event.target) && !dropdown.contains(event.target)) {
          dropdown.classList.add('hidden');
        }
      });
    });
  </script>

  @stack('script')
</body>

</html>
