<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $suffix = ['Shirt', 'Pant', 'Sweater', 'Glasses', 'Hat', 'Socks', 'Trouser', 'Saree'];
        $name = $this->faker->company . ' ' . Arr::random($suffix);
        return [
            'name' => $name,
			'price' => $this->faker->numberBetween(10, 100),
			'description' => $this->faker->realText(200)
        ];
    }
}
