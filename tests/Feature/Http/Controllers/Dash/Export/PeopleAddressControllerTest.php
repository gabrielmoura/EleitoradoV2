<?php

namespace Tests\Feature\Http\Controllers\Dash\Export;

use Tests\TestCase;

class PeopleAddressControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     */
    public function test_example(): void
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }
}
