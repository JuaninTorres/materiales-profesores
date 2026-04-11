<?php

use App\Models\Material;

test('navbar renders with site classes', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('navbar-site', false);
    $response->assertSee('site-footer', false);
});
