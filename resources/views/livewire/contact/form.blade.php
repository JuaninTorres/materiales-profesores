<div class="max-w-2xl mx-auto">
  <h1 class="text-2xl font-bold mb-4">Contacto</h1>

  @if (session('contact_ok'))
      <div class="alert alert-success">{{ session('contact_ok') }}</div>
    @endif

  <form wire:submit="send" class="space-y-4">
    {{-- Honeypot (debe permanecer vacío) --}}
    <div class="hidden">
      <label for="website" class="block text-sm">Sitio web</label>
      <input id="website" type="text" wire:model="website" autocomplete="off" tabindex="-1" />
    </div>

    <div>
        <label for="name" class="label">Nombre</label>
        <input id="name" class="input" wire:model.live="name">
        @error('name') <p class="error">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="email" class="block text-sm font-medium">Correo</label>
      <input id="email" type="email" wire:model.live="email" class="mt-1 w-full border rounded px-3 py-2" required>
      @error('email') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="subject" class="block text-sm font-medium">Asunto (opcional)</label>
      <input id="subject" type="text" wire:model.live="subject" class="mt-1 w-full border rounded px-3 py-2" placeholder="Consulta, clase, material, etc.">
      @error('subject') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div>
      <label for="message" class="block text-sm font-medium">Mensaje</label>
      <textarea id="message" rows="6" wire:model.live="message" class="mt-1 w-full border rounded px-3 py-2" required></textarea>
      @error('message') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">✉️ Enviar</button>
        <a href="{{ route('home') }}" class="btn btn-secondary">Volver</a>
        <span wire:loading class="text-sm text-gray-600">Enviando...</span>
      @if ($sent)
        <span class="text-sm text-green-700">Mensaje enviado ✅</span>
      @endif
    </div>
  </form>

  <p class="text-xs text-gray-500 mt-6">
    Al enviar, aceptas ser contactado por correo para responder tu consulta.
  </p>
</div>
