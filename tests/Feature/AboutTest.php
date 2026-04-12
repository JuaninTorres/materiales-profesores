<?php

test('about page renders', function () {
    $response = $this->get(route('about'));
    $response->assertStatus(200);
    $response->assertSee('about-hero', false);
    $response->assertSee('achievement-card', false);
});
