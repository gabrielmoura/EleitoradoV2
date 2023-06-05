<?php

namespace Tests\Feature\Livewire\Batch;

use App\Http\Livewire\Batch\Job;
use Livewire\Livewire;
use Tests\TestCase;

class JobTest extends TestCase
{
    /** @test */
    public function the_component_can_render()
    {
        $component = Livewire::test(Job::class);

        $component->assertStatus(200);
    }
}
