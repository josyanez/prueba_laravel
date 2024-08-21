<?php
namespace Tests\Unit;

use Tests\TestCase;
use App\Models\Entity;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EntityTest extends TestCase
{
    use RefreshDatabase;


    /** @test */
    public function it_belongs_to_a_category()
    {
        $category = Category::factory()->create();
        $entity = Entity::factory()->create(['category_id' => $category->id]);

        $this->assertTrue($entity->category->is($category));
    }

    /** @test */
    public function it_has_required_fields()
    {
        $entity = new Entity([
            'api' => 'Test API',
            'description' => 'Test Description',
            'link' => 'http://example.com',
            'category_id' => 1
        ]);

        $this->assertEquals('Test API', $entity->api);
    }
}
