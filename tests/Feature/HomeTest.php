<?php

test('home page renders', function () {
    $response = $this->get('/');
    $response->assertStatus(200);
    $response->assertSee('hero', false);
    $response->assertSee('Matemática', false);
    $response->assertSee('cta-section', false);
});
