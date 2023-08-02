<?php

namespace Tests\Feature\Http\Controllers\Auth;

use App\Models\Company;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use PHPUnit\Framework\Attributes\Test;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class InviteControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    #[Test]
    public function an_invitation_without_a_code(): void
    {
        $response = $this->get('auth/invite');
        $response->assertUnauthorized();
    }

    #[Test]
    public function an_invitation_with_a_code(): void
    {
        $company = Company::factory()->create();
        $url = URL::signedRoute('auth.invite.index', [
            'tenant_id' => $company->tenant_id,
            'company_id' => $company->id,
            'email' => 'test@example.com',
            'role' => 'user',
        ], now()->addMinutes(30));
        $response = $this->get($url);
        $response->assertSee(['tenant_id' => $company->tenant_id, 'company_id' => $company->id]);
    }

    #[Test]
    public function create_a_user_using_invite(): void
    {
        $this->artisan('migrate:fresh');
        Role::create(['name' => 'user']);
        $company = Company::factory()->create();
        $password = Str::password(8, true, true, false, false);
        $url = URL::signedRoute('auth.invite.index', [
            'tenant_id' => $company->tenant_id,
            'company_id' => $company->id,
            'email' => 'test@example.com',
            'role' => 'user',
        ], now()->addMinutes(30));

        $response = $this->withSession([
            'email' => 'test@example.com',
            'role' => 'user',
            'company_id' => $company->id,
        ])->post($url, [
            'name' => 'Test User',
            'password' => $password,
            'password_confirmation' => $password,
            'phone' => '(21) 99999-9999',
        ]);
        $response->assertRedirect(route('login'));
        $this->assertDatabaseHas('users', [
            'name' => 'Test User',
            'email' => 'test@example.com',
            'company_id' => $company->id,
            'phone' => '(21) 99999-9999',
        ]);
    }
}
