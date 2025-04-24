<?php

namespace Database\Factories;

use App\Models\Film;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Film>
 */
class FilmFactory extends Factory
{
    protected $model = Film::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'synopsis' => $this->faker->paragraph(),
            'release_year' => $this->faker->year(),
            'duration' => $this->faker->numberBetween(80, 180),
            'poster_url' => $this->faker->imageUrl(300, 450, 'movies'),
            'director' => $this->faker->name(),
            'rating_avg' => 0,
            'total_reviews' => 0,
        ];
    }

}
