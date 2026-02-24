<div class="container">
    <h1 class="h3 fw-bold m-0">Contacto</h1>


    @if (session('contact_ok'))
        <div class="alert alert-success">{{ session('contact_ok') }}</div>
    @endif

    <form wire:submit="send" class="space-y-4">
        {{-- Honeypot (debe permanecer vacío) --}}
        <div class="d-none">
          <label for="website" class="d-block text-sm">Sitio web</label>
          <input id="website" type="text" wire:model="website" autocomplete="off" tabindex="-1" />
        </div>

        <div class="mb-3">
            <label for="name" class="form-label">Nombre</label>
            <input id="name" class="form-control" wire:model.live="name">
            @error('name') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
          <label for="email" class="form-label">Correo</label>
          <input id="email" type="email" wire:model.live="email" class="form-control" required>
          @error('email') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
          <label for="subject" class="form-label">Asunto (opcional)</label>
          <input id="subject" type="text" wire:model.live="subject" class="form-control" placeholder="Consulta, clase, material, etc.">
          @error('subject') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="mb-3">
          <label for="message" class="form-label">Mensaje</label>
          <textarea id="message" rows="6" wire:model.live="message" class="form-control" required></textarea>
          @error('message') <p class="text-danger">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center gap-3">
            <button type="submit" class="btn btn-primary" wire:loading.attr="disabled">✉️ Enviar</button>
            <a href="{{ route('home') }}" class="btn btn-secondary">Volver</a>
            <span wire:loading class="text-bg-info">Enviando...</span>
          @if ($sent)
            <span class="text-sm text-green-700">Mensaje enviado ✅</span>
          @endif
        </div>
    </form>

    <p class="text-sm-start text-muted mt-5">
        Al enviar, aceptas ser contactado por correo para responder tu consulta.
    </p>
</div>
