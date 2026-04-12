<?php

use App\Models\Material;
use Illuminate\Support\Facades\Blade;

test('navbar renders with site classes', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('navbar-site', false);
    $response->assertSee('site-footer', false);
});

test('mat-card component renders for a published material', function () {
    $material = Material::factory()->create([
        'title' => 'Guía de Álgebra',
        'type' => 'pdf',
        'level' => 'colegio',
        'published' => true,
        'course' => '3° Medio',
    ]);

    $html = Blade::render('<x-materials.card :material="$material" />', ['material' => $material]);

    expect($html)
        ->toContain('mat-card')
        ->toContain('Guía de Álgebra')
        ->toContain('mat-type-pdf')
        ->toContain('3° Medio');
});
