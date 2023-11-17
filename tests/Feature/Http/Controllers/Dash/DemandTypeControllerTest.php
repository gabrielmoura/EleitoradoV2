<?php

namespace Tests\Feature\Http\Controllers\Dash;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class DemandTypeControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }

    #[Test]
    public function a_demand_type()
    {
        $response = $this->get('dash/demand-type');
        $response->assertStatus(200);
    }
}
