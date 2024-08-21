<?php
namespace Database\Factories;

use App\Models\Entity;
use Illuminate\Database\Eloquent\Factories\Factory;

class EntityFactory extends Factory
{
    protected $model = Entity::class;

    public function definition()
    {
        return [
            'api' => $this->faker->unique()->word, 
            'description' => $this->faker->sentence,
            'link' => $this->faker->url,
            'category_id' => \App\Models\Category::factory(), 
        ];
    }
}
