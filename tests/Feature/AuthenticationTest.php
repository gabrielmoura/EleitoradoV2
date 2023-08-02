<?php

namespace Tests\Feature;

use App\Models\Company;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_login_screen_can_be_rendered(): void
    {
        $response = $this->get(route('login'));

        $response->assertStatus(200);
    }

    #[Test]
    public function test_users_can_authenticate_using_the_login_screen(): void
    {
        $password = Str::password(length: 8, symbols: false);
        $company = Company::factory()->create();
        $user = User::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password' => $password,
            'company_id' => $company->id,
        ]);

        $response = $this->post(route('login'), [
            'email' => $user->email,
            'password' => $password,
        ]);

        $this->assertAuthenticated();
        $response->assertRedirect(RouteServiceProvider::HOME);
    }

    #[Test]
    public function test_users_can_not_authenticate_with_invalid_password(): void
    {
        $user = User::factory()->create();

        $this->post(route('login'), [
            'email' => $user->email,
            'password' => 'wrong-password',
        ]);

        $this->assertGuest();
    }
}
