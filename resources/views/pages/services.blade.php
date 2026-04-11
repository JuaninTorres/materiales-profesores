@extends('layouts.app')
@section('title', 'Servicios · Profe Nicolás González')
@section('main_class', '')

@section('full_content')

{{-- PAGE HEADER --}}
<div class="page-header text-center">
    <div class="container">
        <p class="page-header-eyebrow">Asesorías de matemática</p>
        <h1 class="fw-800">Servicios</h1>
        <p class="page-header-lead">
            Clases adaptadas a tu nivel, tu ritmo y tus objetivos.
        </p>
    </div>
</div>

{{-- SERVICE CARDS --}}
<section class="section">
    <div class="container">
        <div class="row g-4 justify-content-center">

            {{-- Clases particulares --}}
            <div class="col-lg-4">
                <div class="service-card service-card-featured">
                    <span class="featured-badge">Más solicitado</span>
                    <div class="service-icon"><i class="bi bi-journal-text" aria-hidden="true"></i></div>
                    <h2 class="h4">Clases particulares</h2>
                    <p class="service-desc">
                        Refuerzo personalizado para estudiantes de 7° básico a 4° medio.
                        Trabajamos los contenidos del curso, preparamos pruebas y cerramos
                        las brechas que el ritmo del colegio no cubre.
                    </p>
                    <ul class="service-includes">
                        <li>Todas las unidades de 7° básico a 4° medio</li>
                        <li>Preparación de pruebas y exámenes</li>
                        <li>Nivelación y refuerzo de contenidos anteriores</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-amber mt-auto">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                    </a>
                </div>
            </div>

            {{-- Preparación PAES --}}
            <div class="col-lg-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-trophy" aria-hidden="true"></i></div>
                    <h2 class="h4">Preparación PAES</h2>
                    <p class="service-desc">
                        Preparación enfocada en la Prueba de Acceso a la Educación Superior.
                        Resolvemos ensayos reales e identificamos errores frecuentes.
                    </p>
                    <ul class="service-includes">
                        <li>Resolución de ensayos oficiales</li>
                        <li>Estrategias por tipo de pregunta</li>
                        <li>Seguimiento del avance durante el año</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary mt-auto">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                    </a>
                </div>
            </div>

            {{-- Nivelación intensiva --}}
            <div class="col-lg-4">
                <div class="service-card">
                    <div class="service-icon"><i class="bi bi-file-earmark-ruled" aria-hidden="true"></i></div>
                    <h2 class="h4">Nivelación intensiva</h2>
                    <p class="service-desc">
                        Para quienes necesitan ponerse al día rápido. Diagnóstico,
                        plan personalizado y materiales a medida.
                    </p>
                    <ul class="service-includes">
                        <li>Diagnóstico inicial de brechas</li>
                        <li>Plan de trabajo personalizado</li>
                        <li>Guías y materiales adaptados</li>
                    </ul>
                    <a href="{{ route('contact') }}" class="btn btn-outline-primary mt-auto">
                        <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                    </a>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- PRACTICAL INFO --}}
<section class="section bg-cream">
    <div class="container">
        <h2 class="fw-800 fs-2 text-center mb-5">Información práctica</h2>
        <div class="row g-4">
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-laptop" aria-hidden="true"></i>Modalidad</h4>
                    <p>Presencial en Quintero y alrededores, u online desde cualquier lugar de Chile vía Zoom o Meet.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-clock" aria-hidden="true"></i>Horarios</h4>
                    <p>Clases a partir de las 18:00 hrs. de lunes a viernes, y en bloques más amplios los fines de semana.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-calendar2-check" aria-hidden="true"></i>¿Cómo agendar?</h4>
                    <p>Escríbeme por el formulario de contacto indicando tu nivel, disponibilidad y lo que necesitas trabajar.</p>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="practical-card">
                    <h4><i class="bi bi-people" aria-hidden="true"></i>Formato</h4>
                    <p>Individual o en grupos pequeños de amigos o compañeros. Los paquetes mensuales también están disponibles.</p>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- LEVELS --}}
<section class="section">
    <div class="container-narrow-md">
        <h2 class="fw-800 fs-2 text-center mb-5">Niveles disponibles</h2>
        <div class="levels-list">
            <div class="level-row">
                <span class="mat-level-dot level-dot-colegio"></span>
                <div>
                    <div class="level-name">Colegio</div>
                    <div class="level-courses">7° básico a 4° medio · todas las asignaturas de matemática</div>
                </div>
            </div>
            <div class="level-row">
                <span class="mat-level-dot level-dot-paes"></span>
                <div>
                    <div class="level-name">PAES Matemática</div>
                    <div class="level-courses">Preparación M1 y M2 · estrategias, ensayos, refuerzo</div>
                </div>
            </div>
            <div class="level-row">
                <span class="mat-level-dot level-dot-cft"></span>
                <div>
                    <div class="level-name">CFT / Instituto</div>
                    <div class="level-courses">Matemática aplicada para formación técnico-profesional</div>
                </div>
            </div>
            <div class="level-row">
                <span class="mat-level-dot level-dot-universidad"></span>
                <div>
                    <div class="level-name">Universidad</div>
                    <div class="level-courses">Cálculo, álgebra lineal, estadística, matemática discreta</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <h2>¿Listo para empezar?</h2>
        <p class="lead">Escríbeme y coordinamos horario y modalidad.</p>
        <div class="d-flex flex-wrap justify-content-center gap-3">
            <a href="{{ route('contact') }}" class="btn btn-amber btn-lg px-5">
                <i class="bi bi-envelope me-2" aria-hidden="true"></i>Contactar ahora
            </a>
            <a href="{{ route('materials.index') }}" class="btn btn-outline-amber btn-lg px-5">
                <i class="bi bi-collection me-2" aria-hidden="true"></i>Ver materiales gratis
            </a>
        </div>
    </div>
</section>

@endsection
