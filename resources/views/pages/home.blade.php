@extends('layouts.app')

@section('title', 'Profe Nicolás González · Matemática para todos')
@section('main_class', '')

@section('full_content')

{{-- ================================================================
     HERO
================================================================ --}}
<section class="hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow">
                    <i class="bi bi-mortarboard-fill me-1" aria-hidden="true"></i>Profesor de Matemática
                </p>
                <h1 class="fw-800">
                    Matemática<br>que <span class="text-amber">se entiende.</span>
                </h1>
                <p class="hero-lead">
                    Hola, soy el <strong>Profe Nicolás González</strong>. Llevo más de 13 años
                    acompañando a estudiantes de colegio, CFT y PAES a entender la matemática
                    —no solo a memorizar fórmulas. Acá encuentras los materiales de mis clases,
                    disponibles para todos.
                </p>
                <div class="d-flex flex-wrap gap-3">
                    <a href="{{ route('materials.index') }}" class="btn btn-amber btn-lg px-4">
                        <i class="bi bi-collection me-2" aria-hidden="true"></i>Explorar materiales
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-amber btn-lg px-4">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Agendar clase
                    </a>
                </div>
            </div>
            <div class="col-lg-5 d-none d-lg-block">
                <img src="{{ asset('images/landing_principal.jpg') }}"
                     alt="Profesor Nicolás González M."
                     class="hero-photo">
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     VALUE PROPS
================================================================ --}}
<section class="section bg-cream">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-file-earmark-text" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="value-title">Material organizado y gratuito</div>
                        <div class="value-desc">Guías, ejercicios y apuntes ordenados por curso y unidad. Sin registro ni costo.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-people" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="value-title">Para todos los niveles</div>
                        <div class="value-desc">Desde 7° básico hasta la PAES y educación técnica. Contenido para cada etapa.</div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="value-card">
                    <div class="value-icon">
                        <i class="bi bi-person-check" aria-hidden="true"></i>
                    </div>
                    <div>
                        <div class="value-title">Asesorías personalizadas</div>
                        <div class="value-desc">Clases particulares adaptadas a tu ritmo y objetivos, presenciales u online.</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     LEVELS
================================================================ --}}
<section class="section">
    <div class="container">
        <div class="text-center mb-5">
            <h2 class="fw-800 fs-2 mb-2">¿En qué nivel estás?</h2>
            <p class="text-muted">Tengo material y clases para distintos contextos educativos.</p>
        </div>
        <div class="row g-3">
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-colegio"></span>
                    <div class="level-pill-text">
                        <div class="level-name">Colegio</div>
                        <div class="level-desc">7° básico a 4° medio</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-paes"></span>
                    <div class="level-pill-text">
                        <div class="level-name">PAES</div>
                        <div class="level-desc">Preparación universitaria</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-cft"></span>
                    <div class="level-pill-text">
                        <div class="level-name">CFT / Instituto</div>
                        <div class="level-desc">Formación técnico-profesional</div>
                    </div>
                </a>
            </div>
            <div class="col-md-6 col-lg-3">
                <a href="{{ route('materials.index') }}" class="level-pill">
                    <span class="level-pill-dot level-dot-universidad"></span>
                    <div class="level-pill-text">
                        <div class="level-name">Universidad</div>
                        <div class="level-desc">Matemática superior</div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     RECENT MATERIALS
================================================================ --}}
@if($recentMaterials->isNotEmpty())
<section class="section bg-cream">
    <div class="container">
        <div class="section-header">
            <h2>Últimos materiales</h2>
            <a href="{{ route('materials.index') }}" class="section-header-link">
                Ver todos <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($recentMaterials as $m)
                <div class="col-md-6 col-xl-4">
                    <x-materials.card :material="$m" />
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     FAQ
================================================================ --}}
<section class="section">
    <div class="container">
        <div class="container-narrow">
            <div class="text-center mb-5">
                <h2 class="fw-800 fs-2 mb-2">Preguntas frecuentes</h2>
            </div>
            <div id="faqAccordion" itemscope itemtype="https://schema.org/FAQPage">

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq1" aria-expanded="false" aria-controls="faq1">
                            ¿Los materiales son realmente gratis?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq1" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Sí, todos los materiales del sitio son gratuitos y de libre descarga. No necesitas crear cuenta ni pagar nada.
                        </div>
                    </div>
                </div>

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq2" aria-expanded="false" aria-controls="faq2">
                            ¿Haces clases online?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq2" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Sí, ofrezco clases presenciales en Quintero y online por Zoom o Meet. Cuéntame tu situación y buscamos la mejor opción.
                        </div>
                    </div>
                </div>

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq3" aria-expanded="false" aria-controls="faq3">
                            ¿Cómo puedo agendar una clase?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq3" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Escríbeme desde el <a href="{{ route('contact') }}">formulario de contacto</a> indicando tu nivel, disponibilidad y lo que necesitas trabajar. Te respondo en menos de 24 horas.
                        </div>
                    </div>
                </div>

                <div class="faq-item" itemscope itemprop="mainEntity" itemtype="https://schema.org/Question">
                    <h3 itemprop="name" class="mb-0">
                        <button class="faq-question collapsed" data-bs-toggle="collapse"
                                data-bs-target="#faq4" aria-expanded="false" aria-controls="faq4">
                            ¿Para qué niveles tienes materiales?
                            <i class="bi bi-chevron-down" aria-hidden="true"></i>
                        </button>
                    </h3>
                    <div id="faq4" class="collapse" data-bs-parent="#faqAccordion"
                         itemscope itemprop="acceptedAnswer" itemtype="https://schema.org/Answer">
                        <div class="faq-answer" itemprop="text">
                            Para colegio (7° básico a 4° medio), PAES, CFT/Instituto y matemática universitaria. Puedes filtrarlos en la sección de materiales.
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     CTA FINAL
================================================================ --}}
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para mejorar tus notas?</h2>
        <p class="lead">Explora los materiales gratuitos o contáctame para una clase personalizada.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('materials.index') }}" class="btn btn-amber btn-lg px-5">
                <i class="bi bi-collection me-2" aria-hidden="true"></i>Ver materiales
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-amber btn-lg px-5">
                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contactar
            </a>
        </div>
    </div>
</section>

@endsection
