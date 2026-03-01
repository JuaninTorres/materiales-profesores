@section('title', 'Materiales · profenicolas.cl')
@section('main_class', 'py-4')

<div>

    {{-- Encabezado --}}
    <div class="mb-4 pb-3 border-bottom">
        <h1 class="h2 fw-bold mb-1">
            <i class="bi bi-collection-fill text-primary me-2" aria-hidden="true"></i>Materiales
        </h1>
        <p class="text-muted mb-0">
            Guías, ejercicios y apuntes de matemática organizados por curso y tipo. Descárgalos gratis.
        </p>
    </div>

    {{-- Filtros / búsqueda --}}
    <div class="bg-body-tertiary rounded-3 p-3 mb-4">

        {{-- Controles superiores: Orden y Vista --}}
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
            <div class="d-flex align-items-center gap-2">
                <label for="sort" class="form-label m-0 small fw-semibold">Ordenar</label>
                <select id="sort" class="form-select form-select-sm w-auto" wire:model.live="sort" aria-label="Ordenar materiales">
                    <option value="recent">Más recientes</option>
                    <option value="title_az">Título A–Z</option>
                    <option value="title_za">Título Z–A</option>
                </select>
            </div>
            <div class="btn-group" role="group" aria-label="Modo de vista">
                <button type="button" class="btn btn-sm btn-outline-secondary @if($view==='cards') active @endif"
                        wire:click="setView('cards')" aria-pressed="{{ $view==='cards' ? 'true' : 'false' }}">
                    <i class="bi bi-grid-3x3-gap" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline ms-1">Cards</span>
                </button>
                <button type="button" class="btn btn-sm btn-outline-secondary @if($view==='list') active @endif"
                        wire:click="setView('list')" aria-pressed="{{ $view==='list' ? 'true' : 'false' }}">
                    <i class="bi bi-list-ul" aria-hidden="true"></i>
                    <span class="d-none d-sm-inline ms-1">Lista</span>
                </button>
            </div>
        </div>

        <div class="row g-2 align-items-end" role="search">
            <div class="col-12 col-md-4">
                <label class="form-label small fw-semibold" for="q">Buscar</label>
                <div class="input-group">
                    <span class="input-group-text bg-white border-end-0">
                        <i class="bi bi-search text-muted" aria-hidden="true"></i>
                    </span>
                    <input id="q" type="search"
                           class="form-control border-start-0 ps-0"
                           placeholder="Tema, curso, tipo…"
                           wire:model.live="q"
                           wire:keydown.enter.prevent
                           wire:keydown.escape="$set('q','')">
                    <button type="button" class="btn btn-outline-secondary"
                            wire:click="$set('q','')" aria-label="Limpiar búsqueda">
                        <i class="bi bi-x-lg" aria-hidden="true"></i>
                    </button>
                </div>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold" for="course">Curso</label>
                <select id="course" class="form-select form-select-sm" wire:model.live="course">
                    <option value="">Todos</option>
                    @foreach($courses as $c)
                        <option value="{{ $c }}">{{ $c }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold" for="type">Tipo</label>
                <select id="type" class="form-select form-select-sm" wire:model.live="type">
                    <option value="">Todos</option>
                    @foreach($types as $t)
                        <option value="{{ $t }}">{{ ucfirst($t) }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold" for="semester">Semestre</label>
                <select id="semester" class="form-select form-select-sm" wire:model.live="semester">
                    <option value="">Todos</option>
                    @foreach($semesters as $s)
                        <option value="{{ $s }}">{{ $s }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-6 col-md-2">
                <label class="form-label small fw-semibold" for="perPage">Por página</label>
                <select id="perPage" class="form-select form-select-sm" wire:model.live="perPage">
                    <option value="9">9</option>
                    <option value="12">12</option>
                    <option value="18">18</option>
                    <option value="24">24</option>
                </select>
            </div>
        </div>

        <div wire:loading.delay class="mt-2">
            <span class="small text-muted">
                <i class="bi bi-hourglass-split me-1" aria-hidden="true"></i>Cargando…
            </span>
        </div>

    </div>

    @if($materials->count())

        {{-- VISTA CARDS --}}
        @if($view === 'cards')
            <div class="row g-4">
                @foreach($materials as $m)
                    <div class="col-12 col-md-6 col-xl-4">
                        <div class="card border-0 shadow-sm h-100 card-hover">
                            <div class="card-body p-4 d-flex flex-column">
                                <div class="d-flex align-items-start justify-content-between gap-2 mb-2">
                                    {!! $m->nivel !!}
                                    <span class="text-muted small">{{ $m->tipo }}</span>
                                </div>
                                <h3 class="h5 fw-bold mb-1">
                                    <a class="text-decoration-none text-body"
                                       href="{{ route('materials.show', $m) }}">
                                        {{ $m->title }}
                                    </a>
                                </h3>
                                <p class="text-muted small mb-2">
                                    {{ $m->course }}@if($m->semester) · Semestre {{ $m->semester }}@endif
                                </p>

                                @if(!empty($m->tags))
                                    <div class="mb-2 d-flex flex-wrap gap-1">
                                        @foreach((array)$m->tags as $tag)
                                            <span class="badge text-bg-light border">#{{ $tag }}</span>
                                        @endforeach
                                    </div>
                                @endif

                                <p class="small text-muted mb-3 flex-grow-1">{{ Str::limit($m->description, 120) }}</p>

                                <div class="d-flex gap-2 mt-auto">
                                    <a href="{{ route('materials.show', $m) }}" class="btn btn-primary btn-sm">
                                        <i class="bi bi-eye me-1" aria-hidden="true"></i>Ver
                                    </a>
                                    @if($m->file_url)
                                        <a href="{{ $m->file_url }}" class="btn btn-outline-secondary btn-sm" download>
                                            <i class="bi bi-download me-1" aria-hidden="true"></i>Descargar
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- VISTA LISTA --}}
        @if($view === 'list')
            <div class="list-group list-group-flush border rounded-3 overflow-hidden">
                @foreach($materials as $m)
                    <a href="{{ route('materials.show', $m) }}"
                       class="list-group-item list-group-item-action d-flex justify-content-between align-items-start gap-3 py-3 px-4">
                        <div class="flex-grow-1 min-width-0">
                            <div class="d-flex align-items-center gap-2 mb-1 flex-wrap">
                                <span class="fw-semibold">{{ $m->title }}</span>
                                {!! $m->nivel !!}
                            </div>
                            <div class="text-muted small">
                                {{ $m->course }} · {{ $m->tipo }}@if($m->semester) · Semestre {{ $m->semester }}@endif
                            </div>
                            @if(!empty($m->tags))
                                <div class="mt-1 d-flex flex-wrap gap-1">
                                    @foreach((array)$m->tags as $tag)
                                        <span class="badge text-bg-light border">#{{ $tag }}</span>
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="d-none d-md-block small text-muted text-end flex-shrink-0" style="max-width: 220px">
                            {{ Str::limit($m->description, 80) }}
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        <div class="d-flex justify-content-center mt-4">
            {{ $materials->onEachSide(1)->withQueryString()->links() }}
        </div>

    @else

        <div class="text-center py-5">
            <i class="bi bi-search display-4 text-muted mb-3 d-block" aria-hidden="true"></i>
            <h3 class="h5 fw-semibold mb-1">Sin resultados</h3>
            <p class="text-muted mb-3">No se encontraron materiales con esos filtros.</p>
            <button type="button" class="btn btn-outline-secondary btn-sm"
                    wire:click="$set('q', ''); $set('course', ''); $set('type', ''); $set('semester', '')">
                <i class="bi bi-arrow-counterclockwise me-1" aria-hidden="true"></i>Limpiar filtros
            </button>
        </div>

    @endif

</div>
