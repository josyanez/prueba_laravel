<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Category;
use App\Models\Entity;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    use RefreshDatabase;

    /** @test */
    public function it_has_many_entities()
    {
        $category = Category::factory()->create();
        $entities = Entity::factory()->count(3)->create(['category_id' => $category->id]);

        $this->assertCount(3, $category->entities);
    }

    /** @test */
    public function it_has_required_fields()
    {
        $category = Category::factory()->create(['category' => 'Security']);

        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'category' => 'Security',
        ]);
    }

}
