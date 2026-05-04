<?php

use App\Models\User;

test('registration screen can be rendered', function () {
    $response = $this->get('/register');

    $response->assertStatus(200);
});

test('new tenants can register', function () {
    $response = $this->post('/register', [
        'name' => 'Test User',
        'email' => 'test@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'tenant',
    ]);

    $this->assertAuthenticated();
    $response->assertRedirect(route('dashboard', absolute: false));

    expect(User::where('email', 'test@example.com')->first()->role->value)->toBe('tenant');
});

test('new landlords can register', function () {
    $response = $this->post('/register', [
        'name' => 'BH Owner',
        'email' => 'owner@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'landlord',
    ]);

    $this->assertAuthenticated();
    expect(User::where('email', 'owner@example.com')->first()->role->value)->toBe('landlord');
});

test('registration requires valid role', function () {
    $response = $this->post('/register', [
        'name' => 'Bad Role',
        'email' => 'bad@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
        'role' => 'super_admin',
    ]);

    $response->assertSessionHasErrors('role');
    $this->assertGuest();
});
