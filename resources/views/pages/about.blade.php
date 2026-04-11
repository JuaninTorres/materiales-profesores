@extends('layouts.app')
@section('title', 'Sobre mí · Profe Nicolás González')
@section('description', 'Nicolás González M., profesor de Matemática con más de 13 años de experiencia en colegio, PAES y CFT. Egresado de la Universidad de Valparaíso. Clases en Quintero u online.')
@section('main_class', '')

@section('full_content')

{{-- HERO --}}
<section class="about-hero">
    <div class="container">
        <div class="row align-items-center g-4">
            <div class="col-lg-7">
                <p class="eyebrow">
                    <i class="bi bi-mortarboard-fill me-1" aria-hidden="true"></i>Profesor de Matemática
                </p>
                <h1 class="fw-800 text-white">
                    Nicolás González M.<br>
                    <span class="text-amber">13 años enseñando</span> matemáticas.
                </h1>
                <p class="about-hero-lead">
                    Egresado de la Universidad de Valparaíso (sede Playa Ancha). Docente
                    en Quintero desde que egresé, con clases particulares desde 2012.
                </p>
                <ul class="list-unstyled about-credentials">
                    <li>
                        <i class="bi bi-award-fill text-amber" aria-hidden="true"></i>
                        4× medalla CMAT (2018, 2019, 2024, 2025)
                    </li>
                    <li>
                        <i class="bi bi-check2-circle text-success" aria-hidden="true"></i>
                        Colegio, CFT, PAES y clases particulares
                    </li>
                    <li>
                        <i class="bi bi-geo-alt-fill" aria-hidden="true"></i>
                        Quintero, Valparaíso — presencial u online
                    </li>
                </ul>
            </div>
            <div class="col-lg-4 offset-lg-1 d-none d-lg-block">
                <div class="about-photo-wrap">
                    <img src="{{ asset('images/about_me.jpg') }}"
                         alt="Nicolás González M., Profesor de Matemática">
                    <span class="photo-badge">
                        <i class="bi bi-award-fill me-1" aria-hidden="true"></i>4× Medalla CMAT
                    </span>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- ACHIEVEMENTS --}}
<section class="section bg-cream">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>+13</h3>
                    <p>años de experiencia</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>3</h3>
                    <p>niveles de enseñanza</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>4×</h3>
                    <p>medalla CMAT</p>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="achievement-card">
                    <h3>100%</h3>
                    <p>materiales gratuitos</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- TIMELINE --}}
<section class="section">
    <div class="container">
        <h2 class="fw-800 fs-2 text-center mb-5">Historia y formación</h2>
        <div class="row g-5">
            <div class="col-lg-6">
                <h3 class="about-timeline-heading">Historia</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="timeline-year">2011</span>
                        <div class="timeline-content">
                            <h4>Ingreso a la UV</h4>
                            <p>Comenzó sus estudios de Pedagogía en Matemáticas en la Universidad de Valparaíso, sede Playa Ancha.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">2012</span>
                        <div class="timeline-content">
                            <h4>Primeras clases particulares</h4>
                            <p>Inició su trabajo en clases particulares y preparación PAES, que mantiene hasta hoy.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">2018</span>
                        <div class="timeline-content">
                            <h4>Titulación y primer CMAT</h4>
                            <p>Se tituló de Profesor de Matemática y obtuvo su primera medalla CMAT acompañando estudiantes.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">2024</span>
                        <div class="timeline-content">
                            <h4>profenicolas.cl</h4>
                            <p>Lanzó este sitio para compartir materiales de forma abierta y gratuita con todos los estudiantes.</p>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <h3 class="about-timeline-heading">Formación</h3>
                <div class="timeline">
                    <div class="timeline-item">
                        <span class="timeline-year">UV</span>
                        <div class="timeline-content">
                            <h4>Licenciatura en Matemática</h4>
                            <p>Universidad de Valparaíso, sede Playa Ancha.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">UV</span>
                        <div class="timeline-content">
                            <h4>Pedagogía en Matemáticas</h4>
                            <p>Titulado 2018. Formación enfocada en didáctica, evaluación y contexto escolar chileno.</p>
                        </div>
                    </div>
                    <div class="timeline-item">
                        <span class="timeline-year">CMAT</span>
                        <div class="timeline-content">
                            <h4>Medallas 2018, 2019, 2024 y 2025</h4>
                            <p>Bronce y plata en el Campeonato Escolar de Matemática, como entrenador y acompañante.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- METHODOLOGY --}}
<section class="section bg-cream">
    <div class="container">
        <h2 class="fw-800 fs-2 text-center mb-5">Cómo enseño</h2>
        <div class="row g-4">
            <div class="col-md-4">
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-sort-down" aria-hidden="true"></i></div>
                    <h3>Diagnóstico primero</h3>
                    <p>Antes de avanzar, identificamos las brechas reales. No asumo lo que el estudiante sabe o no sabe.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-puzzle" aria-hidden="true"></i></div>
                    <h3>Conexión con lo concreto</h3>
                    <p>Parto de ejemplos cotidianos antes de formalizar. Los símbolos deben tener sentido real, no ser algo a memorizar.</p>
                </div>
            </div>
            <div class="col-md-4">
                <div class="method-card">
                    <div class="method-icon"><i class="bi bi-file-earmark-text" aria-hidden="true"></i></div>
                    <h3>Materiales propios</h3>
                    <p>Los materiales son creados por mí y están adaptados al nivel de cada estudiante. Nada genérico.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para trabajar juntos?</h2>
        <p class="lead">Explora los materiales gratuitos o contáctame directamente.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('materials.index') }}" class="btn btn-amber btn-lg px-5">
                <i class="bi bi-collection me-2" aria-hidden="true"></i>Explorar materiales
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline-amber btn-lg px-5">
                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contactar
            </a>
        </div>
    </div>
</section>

@endsection
