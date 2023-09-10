<?php

namespace Database\Factories;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = fake()->sentence(3, true);
        return [
            "title" => $title,
            "slug" => strtolower(str_replace(" ", "-", $title)),
            "description" => fake()->sentences(15, true),
            "image" => "image.jpg",
            "publish_date" => Carbon::today()->subDays(rand(0, 180)),
            "isHeader" => fake()->randomElement([0,1]),
            "isActive" => fake()->randomElement([0,1]),
        ];
    }
}
