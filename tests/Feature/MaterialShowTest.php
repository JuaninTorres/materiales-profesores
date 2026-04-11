<?php

use App\Models\Material;

test('material detail page renders', function () {
    $material = Material::factory()->create([
        'type'      => 'pdf',
        'published' => true,
    ]);

    $response = $this->get(route('materials.show', $material));
    $response->assertStatus(200);
    $response->assertSee('material-detail-grid', false);
    $response->assertSee('ficha-tecnica', false);
});
