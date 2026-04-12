<?php

test('materials index renders with page header', function () {
    $response = $this->get('/materiales');
    $response->assertStatus(200);
    $response->assertSee('page-header', false);
    $response->assertSee('filter-bar', false);
});
