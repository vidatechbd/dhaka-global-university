<?php

test('registration screen redirects to login', function () {
    $response = $this->get('/register');

    $response->assertRedirect(route('login'));
});

test('new users cannot register via post request', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ]);

    $this->assertGuest();
    $response->assertRedirect(route('login'));
});
