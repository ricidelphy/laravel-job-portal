<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    public function testLoginFailedDueToValidationErrors()
    {
        $this->json('POST', 'api/auth/login', [
            'email' => 'wrong_email',
        ])->assertInvalid(['email', 'password']);

        $this->json('POST', 'api/auth/login', [
            'email' => 'demo@gmail.com',
        ])->assertInvalid(['password']);
    }

    public function testLoginFailedDueToUserNotExists()
    {
        $this->json('POST', 'api/auth/login', [
            'email' => 'demo@gmail.com',
            'password' => '123456',
        ])->assertStatus(400);
    }

    public function testLoginSuccessfully()
    {
        $user = User::factory()->create();
        $this->json('POST', 'api/auth/login', [
            'email'     => $user->email,
            'password'  => 'password',
        ])
            ->assertOk()
            ->assertJsonFragment([
                'name'  => $user->name,
                'email' => $user->email,
                'role'  => $user->roles->pluck('name')->first(),
            ]);
    }

    public function testLogoutSuccessfully()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->json('POST', 'api/auth/logout')->assertOk();

        $this->assertEquals(0, $user->tokens()->count());
    }
}
