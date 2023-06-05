<?php

namespace Tests\Feature\Livewire\Adress;

use App\Http\Livewire\Adress\Create;
use Livewire\Livewire;
use Tests\TestCase;

class CreateTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Create::class);

        $component->assertStatus(200);
    }
}
