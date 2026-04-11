@section('title', 'Materiales · profenicolas.cl')
@section('description', 'Biblioteca gratuita de guías, ejercicios y apuntes de matemática para colegio, PAES, CFT y universidad. Sin registro, de libre descarga.')
@section('main_class', '')

<div>

    {{-- PAGE HEADER --}}
    <div class="page-header text-center">
        <div class="container">
            <p class="page-header-eyebrow">
                <i class="bi bi-collection-fill me-1" aria-hidden="true"></i>Biblioteca
            </p>
            <h1 class="fw-800">Materiales</h1>
            <p class="page-header-lead">
                Guías, ejercicios y apuntes de matemática. Descárgalos gratis.
            </p>
        </div>
    </div>

    {{-- FILTER BAR --}}
    <div class="filter-bar">
        <div class="container">
            <div class="d-flex flex-wrap align-items-center gap-2">

                {{-- Search --}}
                <div class="filter-bar-search">
                    <div class="input-group input-group-sm">
                        <span class="input-group-text bg-white border-end-0">
                            <i class="bi bi-search text-muted" aria-hidden="true"></i>
                        </span>
                        <input type="search"
                               class="form-control border-start-0 ps-0"
                               placeholder="Buscar…"
                               wire:model.live="q"
                               wire:keydown.escape="$set('q','')">
                    </div>
                </div>

                {{-- Course --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="course" aria-label="Filtrar por curso">
                    <option value="">Todos los cursos</option>
                    @foreach($courses as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>

                {{-- Unit --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="unit" aria-label="Filtrar por unidad">
                    <option value="">Todas las unidades</option>
                    @foreach($units as $u)
                        <option value="{{ $u }}">{{ $u }}</option>
                    @endforeach
                </select>

                {{-- Tema --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="tema" aria-label="Filtrar por tema">
                    <option value="">Todos los temas</option>
                    @foreach($temas as $t)
                        <option value="{{ $t }}">{{ $t }}</option>
                    @endforeach
                </select>

                {{-- Sort --}}
                <select class="form-select form-select-sm filter-bar-select"
                        wire:model.live="sort" aria-label="Ordenar">
                    <option value="recent">Más recientes</option>
                    <option value="title_az">A–Z</option>
                    <option value="title_za">Z–A</option>
                </select>

                {{-- View toggle --}}
                <div class="view-toggle ms-auto d-flex gap-1" role="group" aria-label="Vista">
                    <button type="button" class="btn-view @if($view==='cards') active @endif"
                            wire:click="setView('cards')" aria-pressed="{{ $view==='cards' ? 'true' : 'false' }}"
                            title="Vista tarjetas">
                        <i class="bi bi-grid-3x3-gap" aria-hidden="true"></i>
                    </button>
                    <button type="button" class="btn-view @if($view==='list') active @endif"
                            wire:click="setView('list')" aria-pressed="{{ $view==='list' ? 'true' : 'false' }}"
                            title="Vista lista">
                        <i class="bi bi-list-ul" aria-hidden="true"></i>
                    </button>
                </div>

            </div>
        </div>
    </div>

    {{-- MAIN CONTENT --}}
    <div class="container py-4">

        {{-- Active filter badges --}}
        @if($q || $course || $unit || $tema)
            <div class="d-flex flex-wrap align-items-center gap-2 mb-3">
                <span class="small text-muted fw-600">Filtros activos:</span>
                @if($q)
                    <span class="filter-badge">
                        "{{ $q }}"
                        <span class="filter-badge-remove" wire:click="$set('q','')" role="button"
                              aria-label="Quitar filtro búsqueda">×</span>
                    </span>
                @endif
                @if($course)
                    <span class="filter-badge">
                        {{ $course }}
                        <span class="filter-badge-remove" wire:click="$set('course','')" role="button"
                              aria-label="Quitar filtro curso">×</span>
                    </span>
                @endif
                @if($unit)
                    <span class="filter-badge">
                        {{ $unit }}
                        <span class="filter-badge-remove" wire:click="$set('unit','')" role="button"
                              aria-label="Quitar filtro unidad">×</span>
                    </span>
                @endif
                @if($tema)
                    <span class="filter-badge">
                        {{ $tema }}
                        <span class="filter-badge-remove" wire:click="$set('tema','')" role="button"
                              aria-label="Quitar filtro tema">×</span>
                    </span>
                @endif
                <button type="button" class="btn btn-link btn-sm text-danger p-0"
                        wire:click="$set('q', ''); $set('course', ''); $set('unit', ''); $set('tema', '')">
                    Borrar filtros
                </button>
            </div>
        @endif

        {{-- Results count --}}
        <p class="small text-muted mb-3" wire:loading.remove>
            {{ $materials->total() }} {{ $materials->total() === 1 ? 'material' : 'materiales' }}
        </p>
        <p class="small text-muted mb-3" wire:loading>
            <i class="bi bi-hourglass-split me-1" aria-hidden="true"></i>Cargando…
        </p>

        @if($materials->count())

            {{-- CARDS VIEW --}}
            @if($view === 'cards')
                <div class="row g-4">
                    @foreach($materials as $m)
                        <div class="col-12 col-md-6 col-xl-4">
                            <x-materials.card :material="$m" />
                        </div>
                    @endforeach
                </div>
            @endif

            {{-- LIST VIEW --}}
            @if($view === 'list')
                <div class="d-flex flex-column gap-2">
                    @foreach($materials as $m)
                        <a href="{{ route('materials.show', $m) }}" class="mat-list-row text-decoration-none">
                            <div class="mat-list-info">
                                <div class="mat-list-title">{{ $m->title }}</div>
                                <div class="mat-list-meta">
                                    {{ $m->course }}
                                    @if($m->unit) · {{ $m->unit }}@endif
                                    @if($m->semester) · Semestre {{ $m->semester }}@endif
                                    · {{ strtoupper($m->type) }}
                                </div>
                            </div>
                            <div class="d-flex align-items-center gap-2">
                                @if(!empty($m->tags))
                                    @foreach(array_slice((array)$m->tags, 0, 2) as $tag)
                                        <span class="badge bg-light text-secondary border mat-tag">#{{ $tag }}</span>
                                    @endforeach
                                @endif
                                <span class="mat-type-badge mat-type-{{ $m->type }}">{{ strtoupper($m->type) }}</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- PAGINATION --}}
            <div class="d-flex justify-content-center mt-4">
                {{ $materials->onEachSide(1)->withQueryString()->links() }}
            </div>

        @else

            <div class="text-center py-5">
                <i class="bi bi-search display-4 text-muted mb-3 d-block" aria-hidden="true"></i>
                <h3 class="h5 fw-semibold mb-1">Sin resultados</h3>
                <p class="text-muted mb-3">No hay materiales con esos filtros.</p>
                <button type="button" class="btn btn-outline-secondary btn-sm"
                        wire:click="$set('q', ''); $set('course', ''); $set('unit', ''); $set('tema', '')">
                    <i class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i>Limpiar filtros
                </button>
            </div>

        @endif

    </div>

</div>
