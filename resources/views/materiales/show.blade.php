@extends('layouts.app')

@section('title', $material->title . ' · Materiales')
@section('main_class', 'py-4')

@push('meta')
    <meta name="description" content="{{ Str::limit(strip_tags($material->description), 155) }}">
    <link rel="canonical" href="{{ route('materials.show', $material) }}">
@endpush

@section('content')

{{-- Navegación --}}
<nav class="mb-4">
    <a href="{{ route('materials.index') }}" class="text-decoration-none text-muted small">
        <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver a Materiales
    </a>
</nav>

{{-- Cabecera + metadata --}}
<div class="row g-4 mb-4">

    {{-- Título, descripción y tags --}}
    <div class="col-lg-8">
        <div class="d-flex flex-wrap align-items-center gap-2 mb-2">
            {!! $material->nivel !!}
            @if($material->year)
                <span class="text-muted small">{{ $material->year }}</span>
            @endif
        </div>

        <h1 class="h2 fw-bold mb-2">{{ $material->title }}</h1>

        @if($material->description)
            <p class="text-muted mb-3">{{ $material->description }}</p>
        @endif

        @if(!empty($material->tags))
            <div class="d-flex flex-wrap gap-2">
                @foreach($material->tags as $tag)
                    <span class="badge text-bg-light border">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </div>

    {{-- Ficha técnica + acciones --}}
    <div class="col-lg-4">
        <div class="bg-body-tertiary rounded-3 p-4">

            <h2 class="h6 text-uppercase text-muted fw-semibold small mb-3">Información</h2>

            <dl class="row row-cols-2 g-2 mb-4 small">
                <dt class="col text-muted fw-normal">Tipo</dt>
                <dd class="col fw-semibold mb-0">{{ $material->tipo }}</dd>

                <dt class="col text-muted fw-normal">Curso</dt>
                <dd class="col fw-semibold mb-0">{{ $material->course }}</dd>

                @if($material->subject)
                    <dt class="col text-muted fw-normal">Asignatura</dt>
                    <dd class="col fw-semibold mb-0">{{ $material->subject }}</dd>
                @endif

                @if($material->unit)
                    <dt class="col text-muted fw-normal">Unidad</dt>
                    <dd class="col fw-semibold mb-0">{{ $material->unit }}</dd>
                @endif

                @if($material->semester)
                    <dt class="col text-muted fw-normal">Semestre</dt>
                    <dd class="col fw-semibold mb-0">{{ $material->semester }}</dd>
                @endif

                @if($material->size_formatted)
                    <dt class="col text-muted fw-normal">Tamaño</dt>
                    <dd class="col fw-semibold mb-0">{{ $material->size_formatted }}</dd>
                @endif

                <dt class="col text-muted fw-normal">Código</dt>
                <dd class="col mb-0"><code class="small">{{ $material->code }}</code></dd>
            </dl>

            {{-- Acciones --}}
            <div class="d-grid gap-2">
                @if($material->type === 'pdf' && $material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}"
                       class="btn btn-primary btn-sm" download>
                        <i class="bi bi-download me-1" aria-hidden="true"></i>Descargar PDF
                    </a>
                @elseif($material->type === 'html' && $material->file_path)
                    <a href="{{ route('materials.content', $material) }}"
                       class="btn btn-primary btn-sm" target="_blank" rel="noopener">
                        <i class="bi bi-play-circle me-1" aria-hidden="true"></i>Abrir presentación
                    </a>
                @elseif($material->type === 'link' && $material->link_url)
                    <a href="{{ $material->link_url }}"
                       class="btn btn-primary btn-sm" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-box-arrow-up-right me-1" aria-hidden="true"></i>Abrir recurso externo
                    </a>
                @elseif($material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}"
                       class="btn btn-primary btn-sm" download>
                        <i class="bi bi-download me-1" aria-hidden="true"></i>Descargar archivo
                    </a>
                @endif

                <a href="{{ route('materials.index') }}" class="btn btn-outline-secondary btn-sm">
                    <i class="bi bi-grid-3x3-gap me-1" aria-hidden="true"></i>Ver todos los materiales
                </a>
            </div>

        </div>
    </div>
</div>

{{-- Visor de contenido --}}
@if($material->type === 'pdf' && $material->file_path)
    <div class="mb-5">
        <iframe src="{{ asset('storage/' . $material->file_path) }}"
                class="w-100 border-0 rounded-3 shadow-sm"
                style="height: 82vh;"
                title="{{ $material->title }}"></iframe>
    </div>

@elseif($material->type === 'image' && $material->file_path)
    <div class="text-center mb-5">
        <img src="{{ asset('storage/' . $material->file_path) }}"
             alt="{{ $material->title }}"
             class="img-fluid rounded-3 shadow-sm">
    </div>

@elseif($material->type === 'video' && $material->file_path)
    <div class="mb-5">
        <video controls class="w-100 rounded-3 shadow-sm">
            <source src="{{ asset('storage/' . $material->file_path) }}">
            Tu navegador no soporta la reproducción de video.
        </video>
    </div>
@endif

{{-- Materiales relacionados --}}
@if($related->isNotEmpty())
    <section class="border-top pt-4">
        <h2 class="h5 fw-bold mb-3">
            <i class="bi bi-collection text-primary me-2" aria-hidden="true"></i>Más materiales de {{ $material->course }}
        </h2>
        <div class="row g-3">
            @foreach($related as $rel)
                <div class="col-md-6 col-xl-3">
                    <a href="{{ route('materials.show', $rel) }}"
                       class="card border-0 bg-body-tertiary h-100 text-decoration-none text-body card-hover">
                        <div class="card-body p-3">
                            <div class="mb-1">{!! $rel->nivel !!}</div>
                            <div class="fw-semibold small mb-1">{{ $rel->title }}</div>
                            <div class="text-muted small">{{ $rel->tipo }}</div>
                        </div>
                    </a>
                </div>
            @endforeach
        </div>
    </section>
@endif

@endsection
