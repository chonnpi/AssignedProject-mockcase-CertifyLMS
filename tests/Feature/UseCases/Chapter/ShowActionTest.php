<?php

declare(strict_types=1);

namespace Tests\Feature\UseCases\Chapter;

use App\Models\Chapter;
use App\Models\Section;
use App\UseCases\Chapter\ShowAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ShowActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_loads_sections_in_ordered_sequence(): void
    {
        $chapter = Chapter::factory()->create();

        $section2 = Section::factory()->for($chapter)->create(['order' => 2]);
        $section1 = Section::factory()->for($chapter)->create(['order' => 1]);

        $loadedChapter = (new ShowAction)($chapter);

        $this->assertSame([$section1->id, $section2->id], $loadedChapter->sections->pluck('id')->all());
    }
}
