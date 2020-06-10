<?php

namespace Tests\Feature;

use Tests\TestCase;

class AuthRegisterTest extends TestCase
{

    public function testItCanRegisterUser()
    {
        $name = $this->faker->name();
        $email = $this->faker->email();


        $response = $this->postJson(route('register'), [
            'name' => $name,
            'email' => $email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ], [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(201);

        $response->assertJson([
           'message' => 'Successfully created user'
        ]);

        $this->assertDatabaseHas('users', [
           'name' => $name,
           'email' => $email
        ]);
    }

    public function testItValidatesUserRegistrationRequiredFields()
    {
        $response = $this->postJson(route('register'), [

        ], [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name' => __('auth.messages.failed.required', ['attribute' => 'name']),
            'email' => __('auth.messages.failed.required', ['attribute' => 'email']),
            'password' => __('auth.messages.failed.required', ['attribute' => 'password']),
        ]);
    }

    public function testItValidatesEmailIsUnique()
    {
        $user = $this->createUser();

        $name = $this->faker->name();

        $response = $this->postJson(route('register'), [
            'name' => $name,
            'email' => $user->email,
            'password' => 'password',
            'password_confirmation' => 'password'
        ], [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'email' => __('auth.messages.failed.unique_email')
        ]);
    }

    public function testItValidatesEmailFormat()
    {
        $response = $this->postJson(route('register'), [
            'name' => $this->faker->name(),
            'email' => 'email',
            'password' => 'password',
            'password_confirmation' => 'password'
        ], [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'email' => __('auth.messages.failed.email')
        ]);
    }

    public function testItValidatesStringFields()
    {
        $response = $this->postJson(route('register'), [
            'name' => 1,
            'email' => $this->faker->email(),
            'password' => 1,
            'password_confirmation' => 1
        ], [
            'Content-Type' => 'application/json',
            'X-Requested-With' => 'XMLHttpRequest'
        ]);

        $response->assertStatus(422);

        $response->assertJsonValidationErrors([
            'name' => __('auth.messages.failed.string', ['attribute' => 'name']),
            'password' => __('auth.messages.failed.string', ['attribute' => 'password']),
        ]);
    }
}
