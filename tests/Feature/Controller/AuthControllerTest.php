<?php

namespace Tests\Feature\Controller;

use App\Models\User;
use Laravel\Sanctum\Sanctum;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{

    // Test Login Validation Errors
    public function testLoginFailedDueToValidationErrors()
    {
        $this->json('POST', 'api/auth/login', [
            'email' => 'wrong_email',
        ])->assertInvalid(['email', 'password']);

        $this->json('POST', 'api/auth/login', [
            'email' => 'demo@gmail.com',
        ])->assertInvalid(['password']);
    }

    // Test Login User Not Exists
    public function testLoginFailedDueToUserNotExists()
    {
        $this->json('POST', 'api/auth/login', [
            'email' => 'demo@gmail.com',
            'password' => '123456',
        ])->assertStatus(400);
    }

    // Test Login Success
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

    // Test Register Freelancer Exists
    public function testFreelancerRegisterExists()
    {
        $user = User::factory()->create();
        $this->json('POST', 'api/auth/freelancer/register', [
            'name'                   => 'Demo Freelancer',
            'email'                  => $user->email,
            'password'               => 'password',
            'password_confirmation'  => 'password',

        ])->assertStatus(422);
    }

    // Test Register Employeer Exists
    public function testEmployeerRegisterExists()
    {
        $user = User::factory()->create();
        $this->json('POST', 'api/auth/freelancer/register', [
            'name'                   => 'Demo Empoloyeer',
            'email'                  => $user->email,
            'password'               => 'password',
            'password_confirmation'  => 'password',

        ])->assertStatus(422);
    }

    // Test Register Employeer Success
    public function testEmployeerRegisterSuccessfully()
    {
        $data = [
            'name'                      => 'Demo Employeer',
            'email'                     => 'employeer@demo.com',
            'password'                  => '123456',
            'password_confirmation'     => '123456',
        ];

        $response = $this->json('POST', 'api/auth/employeer/register', $data);
        $response->assertStatus(200);
    }

    // Test Register Freelancer Success
    public function testFreelancerRegisterSuccessfully()
    {
        $data = [
            'name'                      => 'Demo Freelancer',
            'email'                     => 'freelancer@demo.com',
            'password'                  => '123456',
            'password_confirmation'     => '123456',
        ];

        $response = $this->json('POST', 'api/auth/freelancer/register', $data);
        $response->assertStatus(200);
    }

    // Test Logout Success
    public function testLogoutSuccessfully()
    {
        $user = User::factory()->create();
        Sanctum::actingAs($user);

        $this->json('POST', 'api/auth/logout')->assertOk();

        $this->assertEquals(0, $user->tokens()->count());
    }
}
