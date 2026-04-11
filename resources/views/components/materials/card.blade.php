@props(['material'])

@php
$typeClass = match($material->type) {
    'pdf'   => 'mat-type-pdf',
    'video' => 'mat-type-video',
    'html'  => 'mat-type-html',
    'image' => 'mat-type-image',
    'latex' => 'mat-type-latex',
    'link'  => 'mat-type-link',
    default => 'mat-type-other',
};
$typeIcon = match($material->type) {
    'pdf'   => 'bi-file-earmark-pdf',
    'video' => 'bi-play-circle',
    'html'  => 'bi-globe',
    'image' => 'bi-image',
    'latex' => 'bi-file-earmark-code',
    'link'  => 'bi-link-45deg',
    default => 'bi-file-earmark',
};
$levelDotClass = match($material->level) {
    'colegio'               => 'level-dot-colegio',
    'cft'                   => 'level-dot-cft',
    'instituto'             => 'level-dot-instituto',
    'universidad'           => 'level-dot-universidad',
    'particulares', 'paes'  => 'level-dot-particulares',
    default                 => 'level-dot-particulares',
};
@endphp

<div class="mat-card">
    <div class="mat-card-top">
        <span class="mat-type-badge {{ $typeClass }}">
            <i class="bi {{ $typeIcon }}" aria-hidden="true"></i>
            {{ strtoupper($material->type) }}
        </span>
        <span class="mat-level-dot {{ $levelDotClass }}" title="{{ ucfirst($material->level) }}"></span>
    </div>

    <div class="mat-card-body">
        <div class="mat-card-title">{{ $material->title }}</div>
        <div class="mat-card-meta">
            @if($material->course){{ $material->course }}@endif
            @if($material->unit) · {{ $material->unit }}@endif
            @if($material->year)  · {{ $material->year }}@endif
        </div>
        @if(!empty($material->tags))
            <div class="mat-card-tags">
                @foreach(array_slice((array)$material->tags, 0, 3) as $tag)
                    <span class="badge bg-light text-secondary border mat-tag">#{{ $tag }}</span>
                @endforeach
            </div>
        @endif
    </div>

    <div class="mat-card-footer">
        <span class="mat-pages">
            @if($material->size_formatted)
                <i class="bi bi-file-earmark" aria-hidden="true"></i>
                {{ $material->size_formatted }}
            @endif
        </span>
        <a href="{{ route('materials.show', $material) }}" class="btn btn-sm btn-outline-primary">
            Ver material
        </a>
    </div>
</div>
