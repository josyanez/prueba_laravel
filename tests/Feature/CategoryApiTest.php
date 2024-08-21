<?php
namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Entity;
use App\Models\Category;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryApiTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    public function it_has_many_entities()
    {
        $category = Category::factory()->create();
        $entities = Entity::factory(3)->create(['category_id' => $category->id]);

        $this->assertEquals(3, $category->entities->count());
    }

    /** @test */
    public function it_returns_entities_by_category()
    {
        $category = Category::factory()->create(['category' => 'Test Category']);
        $entity = Entity::factory()->create(['category_id' => $category->id]);

        $response = $this->getJson('/api/Test Category');

        $response->assertStatus(200)
                ->assertJsonStructure([
                    'success',
                    'data' => [
                        '*' => [
                            'api',
                            'description',
                            'link',
                            'category' => [
                                'id',
                                'category'
                            ]
                        ]
                    ]
                ]);
    }
   
    /** @test */
    public function it_handles_invalid_category()
    {
        $response = $this->getJson('/api/InvalidCategory');

        $response->assertStatus(404)
                ->assertJson([
                    'success' => false,
                    'message' => 'Category not found'
                ]);
    }

}
