<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;

class CategoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Category::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'slug' => $this->faker->slug,
            'image' => $this->faker->word,
            'description' => $this->faker->text,
            'is_active' => $this->faker->boolean,
            'sort_order' => $this->faker->numberBetween(-10000, 10000),
            'seo_title' => $this->faker->word,
            'seo_description' => $this->faker->word,
        ];
    }
}
