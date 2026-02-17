<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Category;
use App\Models\Product;

class ProductFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Product::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'category_id' => Category::factory(),
            'name' => $this->faker->name,
            'staff_name' => $this->faker->word,
            'slug' => $this->faker->slug,
            'price' => $this->faker->randomFloat(3, 0, 9999999.999),
            'description' => $this->faker->text,
            'image' => $this->faker->word,
            'ingredients' => $this->faker->text,
            'is_active' => $this->faker->boolean,
            'order_type' => $this->faker->randomElement(["kitchen","counter"]),
            'sort_order' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
