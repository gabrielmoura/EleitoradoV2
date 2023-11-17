<?php

namespace Tests\Feature\Http\Controllers\Dash;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class GroupControllerTest extends TestCase
{
    use RefreshDatabase, WithFaker,WithoutMiddleware;

    #[Test]
    public function get_groups(): void
    {
        $this->withoutExceptionHandling();

        $this->be(User::factory()->create());
        $response = $this->get(route('dash.group.index'));

        $response->assertStatus(200);
    }
    // create Group
    //    #[Test]
    //    public function create_group(): void
    //    {
    //        $this->withoutExceptionHandling();
    //
    //        $this->be(User::factory()->create());
    //        $response = $this->post(route('dash.group.store'), [
    //            'name' => $this->faker->name,
    //            'description' => $this->faker->text,
    //        ]);
    //
    //        $response->assertStatus(302);
    //        $this->assertDatabaseHas('groups', [
    //            'name' => $response['name'],
    //            'description' => $response['description'],
    //        ]);
    //    }
}
