<?php

namespace Tests\Feature\Mail\System;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class InvitedMailTest extends TestCase
{
    use RefreshDatabase;
    use WithoutMiddleware;

    public function setUp(): void
    {
        parent::setUp();

        $this->artisan('migrate:fresh');
    }

    #[Test]
    public function a_invited_mail()
    {
        $response = $this->get('/mail/system/invited');
        $response->assertStatus(200);
    }
}
