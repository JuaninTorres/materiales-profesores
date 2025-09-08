<!doctype html>
<html lang="es">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>{{ $title ?? 'Profe Nicolás' }}</title>

  @vite(['resources/css/app.css', 'resources/js/app.js'])
  @livewireStyles
</head>
<body class="min-h-screen bg-gray-50 text-gray-900">
  <header class="bg-white border-b">
    <nav class="container mx-auto flex items-center justify-between p-4">
      <a href="{{ route('home') }}" class="font-bold text-lg">Profe Nicolás</a>
      <ul class="flex gap-4 text-sm">
        <li><a href="{{ route('materials.index') }}" class="hover:underline">Materiales</a></li>
        <li><a href="{{ route('about') }}" class="hover:underline">Sobre mí</a></li>
        <li><a href="{{ route('services') }}" class="hover:underline">Servicios</a></li>
        <li><a href="{{ route('contact') }}" class="hover:underline">Contacto</a></li>
        {{-- Enlace al panel admin (Filament). Usamos /admin para evitar depender de nombres de ruta) --}}
        <li><a href="/admin" class="hover:underline">Admin</a></li>
      </ul>
    </nav>
  </header>

  <main class="container mx-auto p-4">
    {{-- PARA Livewire (->layout) --}}
    {{ $slot ?? '' }}

    {{-- PARA páginas con @extends --}}
    @yield('content')
  </main>

  <footer class="container mx-auto p-4 text-center text-xs text-gray-500">
    © {{ date('Y') }} Profe Nicolás
  </footer>

  {{-- Carga opcional para materiales HTML que usen Chart.js --}}
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

  @livewireScripts
</body>
</html>
