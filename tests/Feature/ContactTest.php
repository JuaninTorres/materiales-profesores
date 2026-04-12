<?php

test('contact page renders', function () {
    $response = $this->get(route('contact'));
    $response->assertStatus(200);
    $response->assertSee('contact-grid', false);
    $response->assertSee('subject-selector', false);
});
