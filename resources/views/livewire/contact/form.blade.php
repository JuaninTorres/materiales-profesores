@section('title', 'Contacto · profenicolas.cl')
@section('description', 'Escríbele al Profe Nicolás González para agendar una clase particular de matemática o resolver tus dudas. Respuesta en menos de 24 horas.')
@section('main_class', '')

<div>

    {{-- PAGE HEADER --}}
    <div class="page-header text-center">
        <div class="container">
            <p class="page-header-eyebrow">
                <i class="bi bi-envelope-heart-fill me-1" aria-hidden="true"></i>Escríbeme
            </p>
            <h1 class="fw-800">Contacto</h1>
            <p class="page-header-lead">
                ¿Tienes dudas con la materia o quieres agendar una clase? Te respondo en menos de 24 horas.
            </p>
        </div>
    </div>

    <div class="container py-5">

        @if($sent)

            <div class="alert alert-success d-flex align-items-start gap-3 p-4" role="alert">
                <i class="bi bi-check-circle-fill fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <h2 class="h5 fw-bold mb-1">¡Mensaje enviado!</h2>
                    <p class="mb-3">Gracias por escribirme. Te responderé a la brevedad.</p>
                    <a href="{{ route('home') }}" class="btn btn-success btn-sm">
                        <i class="bi bi-house me-1" aria-hidden="true"></i>Volver al inicio
                    </a>
                </div>
            </div>

        @else

            <div class="contact-grid">

                {{-- FORM --}}
                <div>
                    <form wire:submit="send" novalidate>

                        {{-- Honeypot --}}
                        <div class="d-none" aria-hidden="true">
                            <input type="text" wire:model="website" autocomplete="off" tabindex="-1">
                        </div>

                        <div class="row g-3 mb-3">
                            <div class="col-sm-6">
                                <label for="name" class="form-label fw-semibold">Nombre</label>
                                <input id="name" type="text"
                                       class="form-control @error('name') is-invalid @enderror"
                                       wire:model.live="name" autocomplete="name">
                                @error('name')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                            <div class="col-sm-6">
                                <label for="email" class="form-label fw-semibold">Correo electrónico</label>
                                <input id="email" type="email"
                                       class="form-control @error('email') is-invalid @enderror"
                                       wire:model.live="email" autocomplete="email">
                                @error('email')<div class="invalid-feedback">{{ $message }}</div>@enderror
                            </div>
                        </div>

                        {{-- Subject radio grid --}}
                        <div class="mb-3">
                            <label class="form-label fw-semibold">
                                Asunto <span class="fw-normal text-muted">(opcional)</span>
                            </label>
                            <div class="subject-selector">
                                @foreach([
                                    'Clases particulares',
                                    'Preparación PAES',
                                    'Duda sobre materia',
                                    'Descarga de material',
                                    'Nivelación intensiva',
                                    'Otro tema',
                                ] as $option)
                                    <div class="subject-option">
                                        <input type="radio"
                                               id="subject_{{ Str::slug($option) }}"
                                               wire:model.live="subject"
                                               value="{{ $option }}">
                                        <label for="subject_{{ Str::slug($option) }}">{{ $option }}</label>
                                    </div>
                                @endforeach
                            </div>
                            @error('subject')<div class="text-danger small">{{ $message }}</div>@enderror
                        </div>

                        <div class="mb-4">
                            <label for="message" class="form-label fw-semibold">Mensaje</label>
                            <textarea id="message" rows="6"
                                      class="form-control @error('message') is-invalid @enderror"
                                      wire:model.live="message"></textarea>
                            @error('message')<div class="invalid-feedback">{{ $message }}</div>@enderror
                        </div>

                        <button type="submit" class="btn btn-amber px-5"
                                wire:loading.attr="disabled" wire:target="send">
                            <i class="bi bi-send me-2" aria-hidden="true"
                               wire:loading.remove wire:target="send"></i>
                            <i class="bi bi-hourglass-split me-2" aria-hidden="true"
                               wire:loading wire:target="send"></i>
                            <span wire:loading.remove wire:target="send">Enviar mensaje</span>
                            <span wire:loading wire:target="send">Enviando…</span>
                        </button>

                        <p class="text-muted small mt-3 mb-0">
                            Al enviar aceptas ser contactado por correo para responder tu consulta.
                        </p>

                    </form>
                </div>

                {{-- SIDEBAR --}}
                <aside class="d-flex flex-column gap-3">

                    {{-- Info card --}}
                    <div class="sidebar-card">
                        <h2 class="ficha-heading">Información de contacto</h2>
                        <div class="d-flex flex-column gap-3">
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-envelope-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Correo</div>
                                    <a href="mailto:hola@profenicolas.cl" class="text-muted small">hola@profenicolas.cl</a>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-geo-alt-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Ubicación</div>
                                    <span class="text-muted small">Quintero, Valparaíso. Online para el resto del país.</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-clock-fill text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Horario</div>
                                    <span class="text-muted small">Clases desde las 18:00 hrs. de lunes a viernes.</span>
                                </div>
                            </div>
                            <div class="d-flex align-items-start gap-3">
                                <i class="bi bi-laptop text-primary fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                                <div>
                                    <div class="fw-semibold small">Modalidad</div>
                                    <span class="text-muted small">Presencial u online, lo que te sea más cómodo.</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Response time card --}}
                    <div class="response-time-card">
                        <div class="response-indicator">
                            <span class="dot-green" aria-hidden="true"></span>
                            Tiempo de respuesta
                        </div>
                        <div class="response-time-value">Menos de 24 horas</div>
                    </div>

                    {{-- Materials promo --}}
                    <div class="sidebar-card">
                        <p class="fw-700 mb-1">¿Solo buscas material?</p>
                        <p class="text-muted small mb-3">Tengo guías, ejercicios y apuntes gratuitos disponibles para descargar.</p>
                        <a href="{{ route('materials.index') }}" class="btn btn-outline-primary btn-sm w-100">
                            <i class="bi bi-collection me-1" aria-hidden="true"></i>Ver materiales
                        </a>
                    </div>

                </aside>

            </div>

        @endif

    </div>

</div>
