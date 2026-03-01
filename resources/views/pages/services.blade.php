@extends('layouts.app')
@section('title', 'Servicios · Profe Nicolás González')
@section('main_class', 'py-4')

@section('content')

{{-- Encabezado --}}
<div class="mb-5 pb-3 border-bottom">
    <h1 class="h2 fw-bold mb-1">
        <i class="bi bi-stars text-primary me-2" aria-hidden="true"></i>Servicios
    </h1>
    <p class="text-muted mb-0">
        Clases adaptadas a tu nivel, tu ritmo y tus objetivos. Sin precios fijos: escríbeme y lo coordinamos.
    </p>
</div>

{{-- Servicios principales --}}
<div class="row g-4 mb-5">

    {{-- Clases particulares --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="mb-3">
                    <i class="bi bi-journal-text display-5 text-primary" aria-hidden="true"></i>
                </div>
                <h2 class="h5 fw-bold mb-2">Clases particulares</h2>
                <p class="text-muted mb-3">
                    Refuerzo personalizado para estudiantes de 7° básico a 4° medio.
                    Trabajamos los contenidos del curso, preparamos pruebas y cerramos
                    las brechas que el ritmo del colegio no permite cubrir.
                </p>
                <ul class="list-unstyled text-muted small mb-4">
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Todas las unidades de 7° básico a 4° medio
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Preparación de pruebas y exámenes
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Nivelación y refuerzo de contenidos anteriores
                    </li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-primary mt-auto">
                    <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                </a>
            </div>
        </div>
    </div>

    {{-- Preparación PAES --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100 border-top border-4 border-primary">
            <div class="card-body p-4 d-flex flex-column">
                <div class="mb-3 d-flex align-items-start justify-content-between">
                    <i class="bi bi-trophy display-5 text-primary" aria-hidden="true"></i>
                    <span class="badge text-bg-primary">Más solicitado</span>
                </div>
                <h2 class="h5 fw-bold mb-2">Preparación PAES</h2>
                <p class="text-muted mb-3">
                    Preparación enfocada en la Prueba de Acceso a la Educación Superior.
                    Resolvemos ensayos reales, identificamos errores frecuentes y trabajamos
                    estrategias para optimizar el puntaje.
                </p>
                <ul class="list-unstyled text-muted small mb-4">
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Resolución de ensayos oficiales
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Estrategias por tipo de pregunta
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Seguimiento del avance durante el año
                    </li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-primary mt-auto">
                    <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                </a>
            </div>
        </div>
    </div>

    {{-- Material personalizado --}}
    <div class="col-lg-4">
        <div class="card border-0 shadow-sm h-100">
            <div class="card-body p-4 d-flex flex-column">
                <div class="mb-3">
                    <i class="bi bi-file-earmark-ruled display-5 text-primary" aria-hidden="true"></i>
                </div>
                <h2 class="h5 fw-bold mb-2">Material personalizado</h2>
                <p class="text-muted mb-3">
                    Guías, ejercicios y resúmenes elaborados según lo que el estudiante
                    necesita. El material se adapta al nivel, al contenido y al estilo
                    de aprendizaje de cada persona.
                </p>
                <ul class="list-unstyled text-muted small mb-4">
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Guías de ejercicios a medida
                    </li>
                    <li class="d-flex align-items-center gap-2 mb-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Resúmenes y esquemas de contenido
                    </li>
                    <li class="d-flex align-items-center gap-2">
                        <i class="bi bi-check2 text-success flex-shrink-0" aria-hidden="true"></i>
                        Ejercicios de repaso previo a pruebas
                    </li>
                </ul>
                <a href="{{ route('contact') }}" class="btn btn-primary mt-auto">
                    <i class="bi bi-calendar2-check me-2" aria-hidden="true"></i>Consultar
                </a>
            </div>
        </div>
    </div>

</div>

{{-- Detalles prácticos --}}
<div class="bg-body-tertiary rounded-3 p-4 p-lg-5 mb-5">
    <h2 class="h4 fw-bold mb-4">
        <i class="bi bi-info-circle-fill text-primary me-2" aria-hidden="true"></i>Detalles prácticos
    </h2>
    <div class="row g-4">
        <div class="col-sm-6 col-lg-3">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-clock-fill text-primary fs-5 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">Duración</div>
                    <span class="text-muted small">Entre 60 y 75 minutos por sesión.</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-laptop text-primary fs-5 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">Modalidad</div>
                    <span class="text-muted small">Presencial en Quintero y alrededores, u online desde cualquier lugar.</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-people-fill text-primary fs-5 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">Formato</div>
                    <span class="text-muted small">Individual o en grupos pequeños de amigos o conocidos.</span>
                </div>
            </div>
        </div>
        <div class="col-sm-6 col-lg-3">
            <div class="d-flex align-items-start gap-3">
                <i class="bi bi-calendar-month-fill text-primary fs-5 flex-shrink-0 mt-1" aria-hidden="true"></i>
                <div>
                    <div class="fw-semibold mb-1">Paquetes mensuales</div>
                    <span class="text-muted small">Disponibles para quienes prefieren planificar sus clases mes a mes.</span>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- CTA --}}
<div class="card border-0 bg-primary text-white text-center p-4 p-lg-5">
    <div class="card-body">
        <i class="bi bi-chat-dots-fill display-5 mb-3 d-block opacity-75" aria-hidden="true"></i>
        <h2 class="h4 fw-bold mb-2">¿Listo para empezar?</h2>
        <p class="opacity-75 mb-4">
            Escríbeme y cuéntame qué necesitas. Coordinamos horario, modalidad y el servicio que mejor se adapte a ti.
        </p>
        <a href="{{ route('contact') }}" class="btn btn-light btn-lg px-5 fw-semibold">
            <i class="bi bi-envelope-fill me-2" aria-hidden="true"></i>Escríbeme
        </a>
    </div>
</div>

@endsection
