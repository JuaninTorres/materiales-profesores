@extends('layouts.app')

@section('title', 'Profe Nicolás González · Matemática para todos')
@section('main_class', '')

@section('full_content')

{{-- ================================================================
     HERO — sin AOS (sobre el fold, visible de inmediato)
================================================================ --}}
<section class="bg-primary text-white py-5">
    <div class="container py-4">
        <div class="row align-items-center g-5">
            <div class="col-lg-7 text-center text-lg-start">
                <p class="text-white-50 text-uppercase fw-semibold mb-2 small">
                    <i class="bi bi-mortarboard-fill me-1" aria-hidden="true"></i>Profesor de Matemática
                </p>
                <h1 class="display-4 fw-bold lh-sm mb-4">
                    Matemática<br>que se entiende.
                </h1>
                <p class="lead mb-5 opacity-75">
                    Hola, soy el <strong class="text-white">Profe Nicolás González</strong>.
                    Llevo más de 13 años acompañando a estudiantes de colegio, CFT y PAES a
                    entender la matemática —no solo a memorizar fórmulas. Acá encuentras
                    los materiales de mis clases, disponibles para todos.
                </p>
                <div class="d-flex flex-wrap gap-3 justify-content-center justify-content-lg-start">
                    <a href="{{ route('materials.index') }}" class="btn btn-light btn-lg px-4 fw-semibold">
                        <i class="bi bi-collection me-2" aria-hidden="true"></i>Explorar materiales
                    </a>
                    <a href="{{ route('contact') }}" class="btn btn-outline-light btn-lg px-4">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Agendar una clase
                    </a>
                </div>
            </div>
            <div class="col-lg-5 text-center d-none d-lg-block">
                <img src="{{ asset('images/landing_principal.jpg') }}"
                     alt="Profesor Nicolás González M."
                     class="landing-hero-photo img-fluid">
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     PROPUESTA DE VALOR
================================================================ --}}
<section class="py-5">
    <div class="container py-3">
        <div class="row g-4 text-center">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="p-3">
                    <i class="bi bi-file-earmark-text display-4 text-primary mb-3 d-block" aria-hidden="true"></i>
                    <h2 class="h5 fw-bold">Material organizado y gratuito</h2>
                    <p class="text-muted mb-0">
                        Guías, ejercicios y apuntes ordenados por curso, unidad y tipo.
                        Descárgalos cuando los necesites, sin registros.
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="p-3">
                    <i class="bi bi-people display-4 text-primary mb-3 d-block" aria-hidden="true"></i>
                    <h2 class="h5 fw-bold">Para todos los niveles</h2>
                    <p class="text-muted mb-0">
                        Desde séptimo básico hasta la PAES y formación técnica.
                        Si estudias matemática en Chile, hay contenido para ti.
                    </p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="p-3">
                    <i class="bi bi-person-check display-4 text-primary mb-3 d-block" aria-hidden="true"></i>
                    <h2 class="h5 fw-bold">Asesorías personalizadas</h2>
                    <p class="text-muted mb-0">
                        Clases particulares adaptadas a tu ritmo y tus objetivos.
                        Escríbeme y lo coordinamos.
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     NIVELES
================================================================ --}}
<section class="py-5 bg-body-tertiary">
    <div class="container py-3">
        <h2 class="h3 fw-bold text-center mb-2" data-aos="fade-up">¿En qué nivel estás?</h2>
        <p class="text-center text-muted mb-5" data-aos="fade-up" data-aos-delay="50">
            Tengo material y clases disponibles para tres contextos distintos.
        </p>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="0">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <i class="bi bi-building display-5 text-success mb-3" aria-hidden="true"></i>
                        <h3 class="h5 fw-bold">Colegio</h3>
                        <p class="text-muted flex-grow-1">
                            7° básico a 4° medio. Guías, ejercicios y materia
                            de cada unidad, ordenados por curso.
                        </p>
                        <a href="{{ route('materials.index') }}"
                           class="btn btn-outline-success btn-sm">
                            Ver materiales
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <i class="bi bi-tools display-5 text-primary mb-3" aria-hidden="true"></i>
                        <h3 class="h5 fw-bold">CFT</h3>
                        <p class="text-muted flex-grow-1">
                            Matemática aplicada para formación técnico-profesional.
                            Contenidos prácticos para el mundo laboral.
                        </p>
                        <a href="{{ route('materials.index') }}"
                           class="btn btn-outline-primary btn-sm">
                            Ver materiales
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body p-4 text-center d-flex flex-column">
                        <i class="bi bi-trophy display-5 text-warning mb-3" aria-hidden="true"></i>
                        <h3 class="h5 fw-bold">PAES · Particulares</h3>
                        <p class="text-muted flex-grow-1">
                            Preparación intensiva para la prueba de selección universitaria.
                            Ensayos, estrategias y resolución de problemas reales.
                        </p>
                        <a href="{{ route('materials.index') }}"
                           class="btn btn-outline-warning btn-sm">
                            Ver materiales
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ================================================================
     MATERIALES RECIENTES (solo si hay materiales publicados)
================================================================ --}}
@if($recentMaterials->isNotEmpty())
<section class="py-5">
    <div class="container py-3">
        <div class="d-flex justify-content-between align-items-center mb-4" data-aos="fade-up">
            <h2 class="h3 fw-bold mb-0">Últimos materiales</h2>
            <a href="{{ route('materials.index') }}" class="btn btn-outline-primary btn-sm">
                Ver todos <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
            </a>
        </div>
        <div class="row g-4">
            @foreach($recentMaterials as $m)
                <div class="col-md-6 col-xl-3" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                    <div class="card h-100 shadow-sm border-0 position-relative card-hover">
                        <div class="card-body p-4 d-flex flex-column">
                            <div class="mb-2">{!! $m->nivel !!}</div>
                            <h3 class="h6 fw-bold mb-1">
                                <a href="{{ route('materials.show', $m) }}"
                                   class="text-decoration-none text-body stretched-link">
                                    {{ $m->title }}
                                </a>
                            </h3>
                            <p class="text-muted small mb-3">
                                {{ $m->course }} · {{ $m->tipo }}
                            </p>
                            <p class="small mb-0 mt-auto text-muted">
                                {{ Str::limit($m->description, 100) }}
                            </p>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- ================================================================
     SOBRE MÍ
================================================================ --}}
<section class="py-5 bg-body-tertiary">
    <div class="container py-3">
        <div class="row align-items-center g-5">
            <div class="col-lg-7" data-aos="fade-right">
                <h2 class="h3 fw-bold mb-3">Un poco sobre mí</h2>
                <p class="lead text-muted mb-4">
                    Soy profesor de Matemática egresado de la
                    <strong class="text-body">Universidad de Valparaíso</strong>,
                    con más de 13 años trabajando en clases particulares y
                    preparación PAES desde 2012.
                </p>
                <ul class="list-unstyled mb-4">
                    <li class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-award-fill text-warning fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                        <span>
                            He acompañado a estudiantes en el campeonato
                            <strong>CMAT</strong>, obteniendo medallas de bronce y plata
                            en 2018, 2019, 2024 y 2025.
                        </span>
                    </li>
                    <li class="d-flex align-items-start gap-3 mb-3">
                        <i class="bi bi-check2-circle text-success fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                        <span>Clases para estudiantes de colegio, CFT e instituciones de educación superior.</span>
                    </li>
                    <li class="d-flex align-items-start gap-3">
                        <i class="bi bi-check2-circle text-success fs-5 mt-1 flex-shrink-0" aria-hidden="true"></i>
                        <span>Preparación PAES adaptada a cada estudiante, desde lo básico hasta el puntaje que necesita.</span>
                    </li>
                </ul>
                <a href="{{ route('about') }}" class="btn btn-outline-primary">
                    Saber más sobre mí <i class="bi bi-arrow-right ms-1" aria-hidden="true"></i>
                </a>
            </div>
            <div class="col-lg-5" data-aos="fade-left">
                <div class="row g-3 text-center">
                    <div class="col-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="display-5 fw-bold text-primary">+13</div>
                            <div class="text-muted small mt-1">años de experiencia</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="display-5 fw-bold text-primary">4</div>
                            <div class="text-muted small mt-1">medallas CMAT</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="display-5 fw-bold text-primary">3</div>
                            <div class="text-muted small mt-1">niveles de enseñanza</div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                            <div class="fw-bold text-primary fs-4 mt-1">UV</div>
                            <div class="text-muted small mt-1">Universidad de Valparaíso</div>
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
<section class="py-5 bg-primary text-white text-center">
    <div class="container py-4" data-aos="fade-up">
        <i class="bi bi-chat-heart-fill display-3 mb-3 d-block opacity-75" aria-hidden="true"></i>
        <h2 class="display-6 fw-bold mb-3">¿Tienes dudas con la materia?</h2>
        <p class="lead mb-4 opacity-75">
            Puedo ayudarte. Si necesitas clases particulares o preparación PAES,<br class="d-none d-md-block">
            escríbeme y coordinamos los horarios que te acomoden.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5 fw-semibold">
            <i class="bi bi-envelope-fill me-2" aria-hidden="true"></i>Escríbeme
        </a>
    </div>
</section>

@endsection
