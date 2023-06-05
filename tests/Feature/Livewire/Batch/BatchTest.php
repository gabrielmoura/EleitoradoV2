<?php

namespace Tests\Feature\Livewire\Batch;

use App\Http\Livewire\Batch\Batch;
use Livewire\Livewire;
use Tests\TestCase;

class BatchTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Batch::class);

        $component->assertStatus(200);
    }
}
