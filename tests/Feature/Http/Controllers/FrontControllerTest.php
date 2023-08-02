<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class FrontControllerTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    #[Test]
    public function a_front_home(): void
    {
        $response = $this->get(route('front.index'));
        $response->assertStatus(200);
    }

    #[Test]
    public function a_front_pricing(): void
    {
        $response = $this->get(route('front.pricing'));
        $response->assertStatus(200);
    }

    #[Test]
    public function a_front_privacy(): void
    {
        $response = $this->get(route('front.privacy'));
        $response->assertStatus(200);
    }

    #[Test]
    public function a_front_terms(): void
    {
        $response = $this->get(route('front.terms'));
        $response->assertStatus(200);
    }

    #[Test]
    public function a_front_faq(): void
    {
        $response = $this->get(route('front.faq'));
        $response->assertStatus(200);
    }
}
