<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<meta name="csrf-token" content="{{ csrf_token() }}">
<title>@yield('title')</title>
<script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="bg-gradient-to-r from-pink-200 via-pink-500 to-rose-200">
<!-- Navbar -->
<nav class="bg-white/80 backdrop-blur-md shadow-lg border-b border-pink-200 sticky top-0 z-50">
  <div class="flex justify-between items-center max-w-6xl mx-auto px-6 py-4">

    <h1 class="font-bold text-xl text-pink-500">
      📸 Cutieshoot
    </h1>

    <div class="space-x-6 font-medium">
      <a href="/"
         class="text-pink-500 hover:text-pink-700 transition">
        Home
      </a>

      <a href="{{ route('booth') }}"
         class="text-pink-500 hover:text-pink-700 transition">
        Booth
      </a>

      <a href="{{ route('gallery') }}"
       class="text-pink-500 hover:text-pink-700 transition">
      Gallery
      </a>
    </div>

  </div>
</nav>

<!-- Content -->
@yield('content')

<!-- Footer -->
<footer class="mt-20 bg-white/80 backdrop-blur-md shadow-lg border-t border-pink-200">
  <div class="max-w-6xl mx-auto px-6 py-6">

      <div class="flex flex-col md:flex-row justify-between items-center gap-3">

          <p class="text-pink-500">
              © 2026 Cutieshoot Booth
          </p>

          <p class="text-pink-500">
              Made with 💖 for portfolio
          </p>

      </div>

  </div>
</footer>

</body>
</html>