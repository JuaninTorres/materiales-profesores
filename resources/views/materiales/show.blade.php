@extends('layouts.app')

@section('title', $material->title . ' · Materiales')
@section('main_class', '')

@php
    $metaDescription = Str::limit(strip_tags($material->description ?? ''), 155)
        ?: $material->title . ' · Material gratuito de matemática de Profe Nicolás González.';
@endphp
@section('description', $metaDescription)
@section('og_type', 'article')
@section('og_title', $material->title . ' · Profe Nicolás')
@section('og_description', $metaDescription)

@if($material->type === 'image' && $material->file_path)
    @section('og_image', asset('storage/' . $material->file_path))
@endif

@section('canonical', route('materials.show', $material))

@section('full_content')

{{-- PAGE HEADER --}}
<div class="material-page-header">
    <div class="container">
        <nav class="material-breadcrumb-nav" aria-label="Ruta de navegación">
            <a href="{{ route('home') }}">Inicio</a>
            <span class="mx-2" aria-hidden="true">›</span>
            <a href="{{ route('materials.index') }}">Materiales</a>
            <span class="mx-2" aria-hidden="true">›</span>
            <span>{{ Str::limit($material->title, 50) }}</span>
        </nav>
        <h1 class="material-page-title">{{ $material->title }}</h1>
    </div>
</div>

{{-- MAIN --}}
<div class="container py-5">
    <div class="material-detail-grid">

        {{-- LEFT: main content --}}
        <div>
            <div class="d-flex flex-wrap gap-2 mb-3">
                {!! $material->nivel !!}
                @if($material->year)
                    <span class="badge bg-light text-secondary border">{{ $material->year }}</span>
                @endif
            </div>

            @if($material->description)
                <div class="material-description text-muted mb-4">
                    {{-- {!! !!} necesario: Str::markdown() genera HTML seguro desde Markdown.
                         html_input='escape' impide inyección de HTML raw. --}}
                    {!! Str::markdown($material->description, ['html_input' => 'escape']) !!}
                </div>
            @endif

            @if(!empty($material->tags))
                <div class="d-flex flex-wrap gap-2 mb-4">
                    @foreach($material->tags as $tag)
                        <span class="badge bg-light text-secondary border mat-tag">#{{ $tag }}</span>
                    @endforeach
                </div>
            @endif

            {{-- VIEWER --}}
            @if($material->type === 'pdf' && $material->file_path)
                <div class="mb-5">
                    <div class="pdf-viewer-toolbar">
                        <span class="pdf-viewer-title">{{ $material->title }}</span>
                        <a href="{{ asset('storage/' . $material->file_path) }}"
                           class="btn btn-sm btn-amber" download>
                            <i class="bi bi-download me-1" aria-hidden="true"></i>Descargar
                        </a>
                    </div>
                    <iframe src="{{ asset('storage/' . $material->file_path) }}"
                            class="pdf-viewer"
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

            <a href="{{ route('materials.index') }}" class="text-muted text-decoration-none small">
                <i class="bi bi-arrow-left me-1" aria-hidden="true"></i>Volver a materiales
            </a>
        </div>

        {{-- RIGHT: sidebar --}}
        <aside>

            {{-- Ficha técnica --}}
            <div class="sidebar-card">
                <h2 class="ficha-heading">Ficha técnica</h2>
                <div class="ficha-tecnica">
                    <div class="ficha-row">
                        <span class="ficha-label">Nivel</span>
                        <span class="ficha-value">{!! $material->nivel !!}</span>
                    </div>
                    @if($material->course)
                    <div class="ficha-row">
                        <span class="ficha-label">Curso</span>
                        <span class="ficha-value">{{ $material->course }}</span>
                    </div>
                    @endif
                    @if($material->subject)
                    <div class="ficha-row">
                        <span class="ficha-label">Asignatura</span>
                        <span class="ficha-value">{{ $material->subject }}</span>
                    </div>
                    @endif
                    @if($material->unit)
                    <div class="ficha-row">
                        <span class="ficha-label">Unidad</span>
                        <span class="ficha-value">{{ $material->unit }}</span>
                    </div>
                    @endif
                    @if($material->semester)
                    <div class="ficha-row">
                        <span class="ficha-label">Semestre</span>
                        <span class="ficha-value">{{ $material->semester }}</span>
                    </div>
                    @endif
                    @if($material->year)
                    <div class="ficha-row">
                        <span class="ficha-label">Año</span>
                        <span class="ficha-value">{{ $material->year }}</span>
                    </div>
                    @endif
                    <div class="ficha-row">
                        <span class="ficha-label">Tipo</span>
                        <span class="ficha-value">{{ $material->tipo }}</span>
                    </div>
                    @if($material->size_formatted)
                    <div class="ficha-row">
                        <span class="ficha-label">Tamaño</span>
                        <span class="ficha-value">{{ $material->size_formatted }}</span>
                    </div>
                    @endif
                </div>
            </div>

            {{-- Download CTA --}}
            <div class="sidebar-card">
                @if($material->type === 'pdf' && $material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}"
                       class="btn btn-amber w-100 mb-2" download>
                        <i class="bi bi-download me-2" aria-hidden="true"></i>Descargar PDF
                    </a>
                @elseif($material->type === 'html' && $material->file_path)
                    @php
                        $esGuia = ($materialSubType === 'guia');
                    @endphp
                    <a href="{{ route('materials.content', $material) }}"
                       class="btn btn-amber w-100 mb-2" target="_blank" rel="noopener">
                        <i class="bi bi-{{ $esGuia ? 'journal-text' : 'play-circle' }} me-2" aria-hidden="true"></i>
                        {{ $esGuia ? 'Abrir guía' : 'Abrir presentación' }}
                    </a>
                    <a href="{{ route('materials.pdf', [$material, 'alumno']) }}"
                       class="btn btn-outline-primary w-100 mb-2">
                        <i class="bi bi-file-earmark-pdf me-2" aria-hidden="true"></i>
                        {{ $esGuia ? 'Imprimir guía (Alumno)' : 'Descargar PDF (Alumno)' }}
                    </a>
                    @auth
                    <a href="{{ route('materials.pdf', [$material, 'docente']) }}"
                       class="btn btn-outline-success w-100 mb-2">
                        <i class="bi bi-file-earmark-pdf-fill me-2" aria-hidden="true"></i>
                        {{ $esGuia ? 'Imprimir guía (Docente)' : 'Descargar PDF (Docente)' }}
                    </a>
                    @endauth
                @elseif($material->type === 'link' && $material->link_url)
                    <a href="{{ $material->link_url }}"
                       class="btn btn-amber w-100 mb-2" target="_blank" rel="noopener noreferrer">
                        <i class="bi bi-box-arrow-up-right me-2" aria-hidden="true"></i>Abrir recurso
                    </a>
                @elseif($material->file_path)
                    <a href="{{ asset('storage/' . $material->file_path) }}"
                       class="btn btn-amber w-100 mb-2" download>
                        <i class="bi bi-download me-2" aria-hidden="true"></i>Descargar archivo
                    </a>
                @endif

                {{-- Share buttons --}}
                <div class="share-buttons mt-2">
                    <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('materials.show', $material)) }}&text={{ urlencode($material->title) }}"
                       class="share-btn" target="_blank" rel="noopener noreferrer"
                       aria-label="Compartir en Twitter/X"
                       data-bs-toggle="tooltip" data-bs-placement="top" title="Compartir en X">
                        <i class="bi bi-twitter-x" aria-hidden="true"></i>
                    </a>
                    <a href="https://wa.me/?text={{ urlencode($material->title . ' ' . route('materials.show', $material)) }}"
                       class="share-btn" target="_blank" rel="noopener noreferrer"
                       aria-label="Compartir por WhatsApp"
                       data-bs-toggle="tooltip" data-bs-placement="top" title="Compartir por WhatsApp">
                        <i class="bi bi-whatsapp" aria-hidden="true"></i>
                    </a>
                    <button type="button" class="share-btn js-copy-link"
                            data-url="{{ route('materials.show', $material) }}"
                            aria-label="Copiar enlace"
                            data-bs-toggle="tooltip" data-bs-placement="top" title="Copiar enlace">
                        <i class="bi bi-link-45deg" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            {{-- Related materials --}}
            @if($related->isNotEmpty())
                <div class="sidebar-card">
                    <h2 class="ficha-heading">Más de {{ $material->course }}</h2>
                    <div class="d-flex flex-column gap-2">
                        @foreach($related as $rel)
                            <a href="{{ route('materials.show', $rel) }}"
                               class="related-item text-decoration-none">
                                <span class="related-title">{{ $rel->title }}</span>
                                <span class="mat-type-badge mat-type-{{ $rel->type }}">{{ strtoupper($rel->type) }}</span>
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif

            {{-- Services CTA --}}
            <div class="sidebar-card sidebar-card-navy">
                <p class="fw-700 mb-1 text-white">¿Necesitas clases?</p>
                <p class="small mb-3 text-on-dark opacity-75">Asesorías personalizadas para tu nivel.</p>
                <a href="{{ route('services') }}" class="btn btn-amber btn-sm w-100">
                    Ver servicios
                </a>
            </div>

        </aside>
    </div>
</div>

@push('scripts')
<script>
document.querySelectorAll('.js-copy-link').forEach(btn => {
    btn.addEventListener('click', () => {
        const url = btn.dataset.url;
        const icon = btn.querySelector('i');

        const confirm = () => {
            icon.className = 'bi bi-check2';
            btn.setAttribute('aria-label', 'Enlace copiado');
            setTimeout(() => {
                icon.className = 'bi bi-link-45deg';
                btn.setAttribute('aria-label', 'Copiar enlace');
            }, 2000);
        };

        if (navigator.clipboard) {
            navigator.clipboard.writeText(url).then(confirm);
        } else {
            const ta = document.createElement('textarea');
            ta.value = url;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            document.execCommand('copy');
            document.body.removeChild(ta);
            confirm();
        }
    });
});
</script>
@endpush

@endsection
