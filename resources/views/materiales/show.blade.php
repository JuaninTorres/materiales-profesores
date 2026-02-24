@extends('layouts.app')

@section('title', $material->title . ' · Materiales')
@push('meta')
  <meta name="description" content="{{ Str::limit(strip_tags($material->description), 155) }}">
  <link rel="canonical" href="{{ route('materials.show', $material) }}">
@endpush

{{--@livewire('materials.favorite-toggle', ['materialId' => $material->id])--}}
@section('content')
<div class="row">
  <div class="col-lg-12 mx-auto">
    <nav class="mb-3">
      <a href="{{ route('materials.index') }}" class="text-decoration-none">
        <i class="bi bi-arrow-left"></i> Volver a Materiales
      </a>
    </nav>

    <article class="card shadow-sm rounded-3">
      <div class="card-body p-4">
        <header class="mb-3">
          <h1 class="h3 fw-bold mb-1">{{ $material->title }}</h1>
          <p class="text-secondary mb-0">
            <i class="bi bi-hash me-1"></i> {{ $material->code }}
            · <i class="bi bi-journal-text ms-2 me-1"></i> {{ $material->course }}
            · <i class="bi bi-collection-play ms-2 me-1"></i> {{ ucfirst($material->type) }}
            @if($material->semester)
              · <i class="bi bi-calendar-event ms-2 me-1"></i> {{ $material->semester }}
            @endif
          </p>
        </header>

        @if($material->description)
          <p class="mb-4">{{ $material->description }}</p>
        @endif

        @if(!empty($material->tags))
          <div class="mb-4 d-flex flex-wrap gap-2">
            @foreach($material->tags as $tag)
              <span class="badge text-bg-info text-dark">#{{ $tag }}</span>
            @endforeach
          </div>
        @endif

        <div class="d-flex flex-wrap gap-2">
          @if($material->html_url)
            <a href="{{ $material->html_url }}" target="_blank" rel="noopener" class="btn btn-primary">
              <i class="bi bi-eye"></i> Ver en línea
            </a>
          @endif

          @if($material->file_url)
            <a href="{{ $material->file_url }}" class="btn btn-outline-secondary" download>
              <i class="bi bi-download"></i> Descargar
            </a>
          @endif

          @if(!$material->html_url && !$material->file_url)
            <span class="text-muted small">No hay archivo asociado.</span>
          @endif
        </div>
      </div>
    </article>

    {{-- (Opcional) relacionados
    @if(isset($related) && $related->isNotEmpty())
      <section class="mt-4">
        <h2 class="h5 fw-semibold mb-3">Materiales relacionados</h2>
        <div class="row g-3">
          @foreach($related as $rel)
            <div class="col-12 col-md-6">
              <a href="{{ route('materials.show', $rel) }}" class="card card-body text-decoration-none h-100">
                <span class="fw-semibold">{{ $rel->title }}</span>
                <small class="text-secondary">{{ $rel->course }} · {{ ucfirst($rel->type) }}</small>
              </a>
            </div>
          @endforeach
        </div>
      </section>
    @endif
    --}}
  </div>
</div>
@endsection
