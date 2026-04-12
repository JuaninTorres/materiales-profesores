<?php echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

    {{-- Páginas estáticas --}}
    @foreach($staticPages as $key => $page)
    <url>
        <loc>{{ route($page['route']) }}</loc>
        <changefreq>{{ $page['changefreq'] }}</changefreq>
        <priority>{{ $page['priority'] }}</priority>
    </url>
    @endforeach

    {{-- Materiales publicados con prioridad dinámica --}}
    @php
        $now = now();
        $oldestMaterialDate = $materials->last()?->updated_at ?? $now;
        $daysSinceOldest = $oldestMaterialDate->diffInDays($now) ?: 1;
    @endphp
    @foreach($materials as $material)
    @php
        // Prioridad dinámica: materiales más recientes tienen mayor prioridad (0.95)
        // materiales más antiguos tienen menor prioridad (0.5)
        $daysSinceUpdate = $material->updated_at->diffInDays($now) ?: 0;
        $recencyScore = 1 - ($daysSinceUpdate / $daysSinceOldest);
        $priority = round(0.5 + (0.45 * $recencyScore), 2);
    @endphp
    <url>
        <loc>{{ route('materials.show', $material->code) }}</loc>
        <lastmod>{{ $material->updated_at->toAtomString() }}</lastmod>
        <changefreq>monthly</changefreq>
        <priority>{{ $priority }}</priority>
    </url>
    @endforeach

</urlset>
