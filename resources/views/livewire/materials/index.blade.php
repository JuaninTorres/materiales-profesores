@section('title','Materiales · profenicolas.cl')

<div>
  {{-- Filtros / búsqueda --}}
<div class="card shadow-sm rounded-3 mb-4">
  <div class="card-body">
      {{-- Controles superiores: Orden y Vista --}}
        <div class="d-flex flex-wrap justify-content-between align-items-end gap-2 mb-3">
          <div class="d-flex align-items-center gap-2">
            <label for="sort" class="form-label m-0">Ordenar</label>
            <select id="sort" class="form-select form-select-sm w-auto" wire:model.live="sort" aria-label="Ordenar materiales">
              <option value="recent">Más recientes</option>
              <option value="title_az">Título A–Z</option>
              <option value="title_za">Título Z–A</option>
            </select>
          </div>

          <div class="btn-group" role="group" aria-label="Modo de vista">
            <button type="button" class="btn btn-outline-secondary @if($view==='cards') active @endif"
                    wire:click="setView('cards')" aria-pressed="{{ $view==='cards' ? 'true':'false' }}">
              <i class="bi bi-grid-3x3-gap"></i> Cards
            </button>
            <button type="button" class="btn btn-outline-secondary @if($view==='list') active @endif"
                    wire:click="setView('list')" aria-pressed="{{ $view==='list' ? 'true':'false' }}">
              <i class="bi bi-list-ul"></i> Lista
            </button>
          </div>
        </div>


    <div class="row g-2 align-items-end" role="search">
      <div class="col-12 col-md-4">
        <label class="form-label" for="q">Buscar</label>
        <div class="input-group">
          <input id="q" type="search" class="form-control"
                 placeholder="Tema, curso, tipo…"
                 wire:model.live="q"
                 wire:keydown.enter.prevent
                 wire:keydown.escape="$set('q','')">
          <button type="button" class="btn btn-outline-secondary"
                  wire:click="$set('q','')" aria-label="Limpiar búsqueda">
            <i class="bi bi-x-lg"></i>
          </button>
        </div>
      </div>

      <div class="col-6 col-md-2">
        <label class="form-label" for="course">Curso</label>
        <select id="course" class="form-select" wire:model.live="course">
          <option value="">Todos</option>
          @foreach($courses as $c) <option value="{{ $c }}">{{ $c }}</option> @endforeach
        </select>
      </div>

      <div class="col-6 col-md-2">
        <label class="form-label" for="type">Tipo</label>
        <select id="type" class="form-select" wire:model.live="type">
          <option value="">Todos</option>
          @foreach($types as $t) <option value="{{ $t }}">{{ ucfirst($t) }}</option> @endforeach
        </select>
      </div>

      <div class="col-6 col-md-2">
        <label class="form-label" for="semester">Semestre</label>
        <select id="semester" class="form-select" wire:model.live="semester">
          <option value="">Todos</option>
          @foreach($semesters as $s) <option value="{{ $s }}">{{ $s }}</option> @endforeach
        </select>
      </div>

      <div class="col-6 col-md-2">
        <label class="form-label" for="perPage">Por página</label>
        <select id="perPage" class="form-select" wire:model.live="perPage">
          <option value="9">9</option>
          <option value="12">12</option>
          <option value="18">18</option>
          <option value="24">24</option>
        </select>
      </div>
    </div>

    <div wire:loading.delay class="mt-2">
      <div class="small text-muted"><i class="bi bi-hourglass-split"></i> Cargando…</div>
    </div>

  </div>
</div>

@if($materials->count())

  {{-- VISTA CARDS --}}
  @if($view === 'cards')
    <div class="row g-4">
      @foreach($materials as $m)
        <div class="col-12 col-md-6 col-xl-4">
          <div class="card shadow-sm rounded-3 h-100">
            <div class="card-body p-4 d-flex flex-column">
              <h3 class="h5 fw-bold mb-1">
                <a class="stretched-link text-decoration-none" href="{{ route('materials.show', $m) }}">
                  {{ $m->title }}
                </a>
              </h3>
              <p class="text-secondary mb-2">
                {{ $m->course }} · {{ ucfirst($m->type) }} @if($m->semester) · {{ $m->semester }} @endif
              </p>

              @if(!empty($m->tags))
                <div class="mb-3 d-flex flex-wrap gap-2">
                  @foreach((array)$m->tags as $tag)
                    <span class="badge text-bg-info text-dark">#{{ $tag }}</span>
                  @endforeach
                </div>
              @endif

              <p class="mb-3">{{ Str::limit($m->description, 140) }}</p>

              <div class="mt-auto d-flex gap-2">
                <a href="{{ route('materials.show', $m) }}" class="btn btn-primary btn-sm">
                  <i class="bi bi-eye"></i> Ver
                </a>
                @if($m->file_url)
                  <a href="{{ $m->file_url }}" class="btn btn-outline-secondary btn-sm" download>
                    <i class="bi bi-download"></i> Descargar
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
    <div class="list-group">
      @foreach($materials as $m)
        <a href="{{ route('materials.show', $m) }}"
           class="list-group-item list-group-item-action d-flex justify-content-between align-items-start">
          <div class="me-3">
            <div class="fw-semibold">{{ $m->title }}</div>
            <small class="text-secondary">
              {{ $m->course }} · {{ ucfirst($m->type) }} @if($m->semester) · {{ $m->semester }} @endif
            </small>
            @if(!empty($m->tags))
              <div class="mt-1 d-flex flex-wrap gap-1">
                @foreach((array)$m->tags as $tag)
                  <span class="badge text-bg-light border">#{{ $tag }}</span>
                @endforeach
              </div>
            @endif
          </div>
          <div class="ms-auto d-none d-md-block small text-muted text-end">
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
      <div class="alert alert-light border d-flex align-items-center" role="alert">
        <i class="bi bi-emoji-neutral me-2"></i>
        <div>No se encontraron materiales con esos filtros.</div>
      </div>
    @endif

</div>
