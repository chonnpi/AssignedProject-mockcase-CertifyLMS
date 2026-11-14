<?php

declare(strict_types=1);

namespace Tests\Feature\UseCases\Part;

use App\Models\Chapter;
use App\Models\Part;
use App\UseCases\Part\ShowAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_loads_chapters_in_ordered_sequence(): void
    {
        $part = Part::factory()->create();

        $chapter2 = Chapter::factory()->for($part)->create(['order' => 2]);
        $chapter1 = Chapter::factory()->for($part)->create(['order' => 1]);

        $loadedPart = (new ShowAction)($part);

        $this->assertSame([$chapter1->id, $chapter2->id], $loadedPart->chapters->pluck('id')->all());
    }
}
