<?php

test('services page renders', function () {
    $response = $this->get(route('services'));
    $response->assertStatus(200);
    $response->assertSee('service-card', false);
    $response->assertSee('service-card-featured', false);
});
