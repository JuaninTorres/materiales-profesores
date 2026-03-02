<div> {{-- raíz Livewire — el container ya lo provee el layout --}}

    {{-- Encabezado de sección --}}
    <div class="mb-4 pb-3 border-bottom">
        <h1 class="h2 fw-bold mb-1">
            <i class="bi bi-envelope-heart-fill text-primary me-2" aria-hidden="true"></i>Contacto
        </h1>
        <p class="text-muted mb-0">
            ¿Tienes dudas con la materia o quieres agendar una clase? Escríbeme.
        </p>
    </div>

    @if($sent)

        {{-- Estado enviado: reemplaza el formulario --}}
        <div class="alert alert-success d-flex align-items-start gap-3 p-4" role="alert">
            <i class="bi bi-check-circle-fill fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
            <div>
                <h2 class="h5 fw-bold mb-1">¡Mensaje enviado!</h2>
                <p class="mb-3">
                    Gracias por escribirme. Te responderé a la brevedad,
                    normalmente en pocas horas o a más tardar al día siguiente.
                </p>
                <a href="{{ route('home') }}" class="btn btn-success btn-sm">
                    <i class="bi bi-house me-1" aria-hidden="true"></i>Volver al inicio
                </a>
            </div>
        </div>

    @else

        <div class="row g-5">

            {{-- Formulario --}}
            <div class="col-lg-7">
                <form wire:submit="send" novalidate>

                    {{-- Honeypot (debe quedar vacío) --}}
                    <div class="d-none" aria-hidden="true">
                        <input type="text" wire:model="website" autocomplete="off" tabindex="-1">
                    </div>

                    <div class="mb-3">
                        <label for="name" class="form-label fw-semibold">Nombre</label>
                        <input id="name" type="text"
                               class="form-control @error('name') is-invalid @enderror"
                               wire:model.live="name" autocomplete="name">
                        @error('name')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                        <input id="email" type="email"
                               class="form-control @error('email') is-invalid @enderror"
                               wire:model.live="email" autocomplete="email">
                        @error('email')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-3">
                        <label for="subject" class="form-label fw-semibold">
                            Asunto <span class="fw-normal text-muted">(opcional)</span>
                        </label>
                        <input id="subject" type="text"
                               class="form-control @error('subject') is-invalid @enderror"
                               wire:model.live="subject"
                               placeholder="Consulta, clase particular, material, etc.">
                        @error('subject')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="mb-4">
                        <label for="message" class="form-label fw-semibold">Mensaje</label>
                        <textarea id="message" rows="6"
                                  class="form-control @error('message') is-invalid @enderror"
                                  wire:model.live="message"></textarea>
                        @error('message')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>

                    <div class="d-flex align-items-center gap-3">
                        <button type="submit" class="btn btn-primary" wire:loading.attr="disabled" wire:target="send">
                            <i class="bi bi-send me-2" aria-hidden="true" wire:loading.remove wire:target="send"></i>
                            <i class="bi bi-hourglass-split me-2" aria-hidden="true" wire:loading wire:target="send"></i>
                            <span wire:loading.remove wire:target="send">Enviar mensaje</span>
                            <span wire:loading wire:target="send">Enviando…</span>
                        </button>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary">Volver</a>
                    </div>

                    <p class="text-muted small mt-4 mb-0">
                        Al enviar, aceptas ser contactado por correo para responder tu consulta.
                    </p>

                </form>
            </div>

            {{-- Información de contacto --}}
            <div class="col-lg-5">
                <div class="bg-body-tertiary rounded-3 p-4 h-100">
                    <h2 class="h6 text-uppercase text-muted fw-semibold mb-4 small ls-1">
                        Información de contacto
                    </h2>
                    <ul class="list-unstyled mb-0">
                        <li class="d-flex align-items-start gap-3 mb-4">
                            <i class="bi bi-envelope-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                            <div>
                                <div class="fw-semibold">Correo</div>
                                <a href="mailto:hola@profenicolas.cl" class="text-muted">
                                    hola@profenicolas.cl
                                </a>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3 mb-4">
                            <i class="bi bi-clock-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                            <div>
                                <div class="fw-semibold">Tiempo de respuesta</div>
                                <span class="text-muted">
                                    Normalmente en pocas horas, a más tardar al día siguiente.
                                </span>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3 mb-4">
                            <i class="bi bi-calendar2-check-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                            <div>
                                <div class="fw-semibold">Horario de clases</div>
                                <span class="text-muted">
                                    A partir de las 18:00 hrs. Coordinamos según tu disponibilidad.
                                </span>
                            </div>
                        </li>
                        <li class="d-flex align-items-start gap-3">
                            <i class="bi bi-laptop text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                            <div>
                                <div class="fw-semibold">Modalidad</div>
                                <span class="text-muted">
                                    Presencial u online, lo que te sea más cómodo.
                                </span>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

        </div>

    @endif

</div>
