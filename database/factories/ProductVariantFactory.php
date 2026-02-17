<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = ProductVariant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'product_id' => Product::factory(),
            'name' => $this->faker->name,
            'staff_name' => $this->faker->word,
            'price_adjustment' => $this->faker->randomFloat(3, 0, 9999999.999),
            'is_required' => $this->faker->boolean,
            'sort_order' => $this->faker->numberBetween(-10000, 10000),
        ];
    }
}
