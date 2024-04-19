<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Category>
 */
class CategoryFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = $this->faker->unique()->realText(40);
        return [
            'name' => $name,
            'slug'  => Str::slug($name),
            'image' => 'categories/'.$this->faker->image('public/storage/categories', 640, 480, null, false),
            'is_featured' => $this->faker->boolean(),
            'status' => $this->faker->boolean(),
        ];
    }
}
