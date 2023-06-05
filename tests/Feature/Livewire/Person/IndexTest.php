<?php

namespace Tests\Feature\Livewire\Person;

use App\Http\Livewire\Person\Index;
use Livewire\Livewire;
use Tests\TestCase;

class IndexTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Index::class);

        $component->assertStatus(200);
    }
}
