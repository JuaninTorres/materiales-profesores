@extends('layouts.app')
@section('title', 'Sobre mí · Profe Nicolás González')
@section('main_class', 'py-4')

@section('content')

{{-- Encabezado --}}
<div class="mb-5 pb-3 border-bottom">
    <h1 class="h2 fw-bold mb-1">
        <i class="bi bi-person-heart-fill text-primary me-2" aria-hidden="true"></i>Sobre mí
    </h1>
    <p class="text-muted mb-0">
        Conoce la historia, la formación y la forma de enseñar del Profe Nicolás.
    </p>
</div>

{{-- Presentación --}}
<div class="row align-items-center g-5 mb-5">
    <div class="col-lg-4 text-center">
        <img src="{{ asset('images/about_me.jpg') }}"
             alt="Nicolás González M., Profesor de Matemática"
             class="about-photo img-fluid">
    </div>
    <div class="col-lg-8">
        <p class="text-primary fw-semibold small text-uppercase mb-1">
            <i class="bi bi-mortarboard-fill me-1" aria-hidden="true"></i>Profesor de Matemática
        </p>
        <h2 class="display-6 fw-bold mb-1">Nicolás González M.</h2>
        <p class="text-muted mb-4">
            Universidad de Valparaíso (sede Playa Ancha) · Titulado 2018 · Quintero, Región de Valparaíso
        </p>

        <blockquote class="border-start border-primary border-3 ps-4 mb-4">
            <p class="lead fst-italic mb-0">
                "Todos los estudiantes pueden aprender matemáticas si se les enseña con paciencia, claridad y sentido."
            </p>
        </blockquote>

        <p class="text-muted mb-0">
            Desde pequeño mostré una gran habilidad y gusto por las matemáticas, lo que con el tiempo
            se transformó en una vocación por enseñar. Mi paso por la universidad no solo fortaleció
            mis conocimientos, sino que también consolidó mi amor por la docencia y mi vínculo con la ciudad de Valparaíso.
        </p>
    </div>
</div>

{{-- Trayectoria --}}
<div class="mb-5">
    <h2 class="h4 fw-bold mb-4">
        <i class="bi bi-briefcase-fill text-primary me-2" aria-hidden="true"></i>Trayectoria
    </h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-0 bg-body-tertiary h-100 card-hover">
                <div class="card-body p-4">
                    <i class="bi bi-building fs-3 text-primary mb-3 d-block" aria-hidden="true"></i>
                    <div class="fw-bold mb-1">Colegio Don Orione</div>
                    <div class="text-muted small mb-3">Quintero · Actualidad</div>
                    <p class="text-muted small mb-0">
                        Docente de Matemática en el mismo establecimiento donde fui estudiante,
                        lo que me vincula profundamente con su comunidad.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-body-tertiary h-100 card-hover">
                <div class="card-body p-4">
                    <i class="bi bi-people-fill fs-3 text-primary mb-3 d-block" aria-hidden="true"></i>
                    <div class="fw-bold mb-1">C.E. Bicentenario Sargento Aldea</div>
                    <div class="text-muted small mb-3">EPJA · Desde hace 3 años</div>
                    <p class="text-muted small mb-0">
                        Educación para jóvenes y adultos, ampliando mi experiencia
                        a distintos niveles y contextos educativos.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 bg-body-tertiary h-100 card-hover">
                <div class="card-body p-4">
                    <i class="bi bi-person-video2 fs-3 text-primary mb-3 d-block" aria-hidden="true"></i>
                    <div class="fw-bold mb-1">Clases particulares y PAES</div>
                    <div class="text-muted small mb-3">Desde 2012</div>
                    <p class="text-muted small mb-0">
                        Asesorías personalizadas para estudiantes de colegio y preparación
                        intensiva para la prueba de selección universitaria.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Metodología --}}
<div class="bg-body-tertiary rounded-3 p-4 p-lg-5 mb-5">
    <h2 class="h4 fw-bold mb-4">
        <i class="bi bi-lightbulb-fill text-primary me-2" aria-hidden="true"></i>Cómo enseño
    </h2>
    <div class="row g-4">
        <div class="col-md-4">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-sort-down text-primary fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">De lo simple a lo complejo</div>
                    <p class="text-muted small mb-0">
                        Parto de ejemplos concretos y cotidianos antes de formalizar con fórmulas.
                        Así cada símbolo tiene sentido real, no es solo algo a memorizar.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-question-circle text-primary fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">Entender el "por qué"</div>
                    <p class="text-muted small mb-0">
                        Trabajo con resolución guiada para que cada estudiante comprenda
                        el procedimiento, no solo lo repita de memoria.
                    </p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-shield-check text-primary fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">Ambiente de confianza</div>
                    <p class="text-muted small mb-0">
                        Equivocarse es parte natural del aprendizaje.
                        En mis clases se puede preguntar sin miedo a quedar mal.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Logros --}}
<div class="mb-5">
    <h2 class="h4 fw-bold mb-4">
        <i class="bi bi-trophy-fill text-warning me-2" aria-hidden="true"></i>Logros destacados
    </h2>
    <div class="row g-4 align-items-start">
        <div class="col-lg-6">
            <p class="text-muted mb-3">
                He acompañado a estudiantes en el
                <strong>Campeonato Escolar de Matemática (CMAT)</strong>,
                obteniendo medallas de bronce y plata en cuatro ocasiones:
            </p>
            <div class="d-flex flex-wrap gap-2">
                @foreach([2018, 2019, 2024, 2025] as $year)
                    <div class="d-flex align-items-center gap-2 bg-body-tertiary rounded-3 px-3 py-2">
                        <i class="bi bi-award-fill text-warning" aria-hidden="true"></i>
                        <span class="fw-semibold">{{ $year }}</span>
                    </div>
                @endforeach
            </div>
        </div>
        <div class="col-lg-6">
            <div class="d-flex align-items-start gap-3 bg-body-tertiary rounded-3 p-3">
                <i class="bi bi-geo-alt-fill text-primary fs-4 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold">¿Dónde atiendo?</div>
                    <p class="text-muted small mb-0">
                        Clases presenciales en Quintero y alrededores, Región de Valparaíso.
                        Para el resto del país, las clases online son igual de efectivas.
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CTAs --}}
<div class="border-top pt-4 d-flex flex-wrap gap-3">
    <a href="{{ route('materials.index') }}" class="btn btn-primary">
        <i class="bi bi-collection me-2" aria-hidden="true"></i>Ver materiales
    </a>
    <a href="{{ route('contact') }}" class="btn btn-outline-primary">
        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Agendar una clase
    </a>
</div>

@endsection
