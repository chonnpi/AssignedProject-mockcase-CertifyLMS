<?php

declare(strict_types=1);

namespace Tests\Feature\UseCases\Part;

use App\Models\Certification;
use App\Models\Chapter;
use App\Models\Part;
use App\UseCases\Part\IndexAction;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class IndexActionTest extends TestCase
{
    use RefreshDatabase;

    public function test_returns_parts_and_chapters_in_ordered_sequence(): void
    {
        $certification = Certification::factory()->create();

        $part2 = Part::factory()->for($certification)->create(['order' => 2]);
        $part1 = Part::factory()->for($certification)->create(['order' => 1]);

        $chapter2 = Chapter::factory()->for($part1)->create(['order' => 2]);
        $chapter1 = Chapter::factory()->for($part1)->create(['order' => 1]);

        $parts = (new IndexAction)($certification);

        $this->assertSame([$part1->id, $part2->id], $parts->pluck('id')->all());
        $this->assertSame([$chapter1->id, $chapter2->id], $parts->first()->chapters->pluck('id')->all());
    }
}
