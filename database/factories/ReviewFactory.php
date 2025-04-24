<?php

namespace Database\Factories;

use App\Models\Review;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Review>
 */
class ReviewFactory extends Factory
{
    protected $model = Review::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $user = \App\Models\User::inRandomOrder()->first();
        $film = \App\Models\Film::inRandomOrder()->first();
        $rating = $this->faker->numberBetween(1, 10);

        $film->increment('total_reviews');
        $film->rating_avg = round(
            (($film->rating_avg * ($film->total_reviews - 1)) + $rating) / $film->total_reviews,
            2
        );
        $film->save();

        return [
            'user_id' => $user->id,
            'film_id' => $film->id,
            'rating' => $rating,
            'comment' => $this->faker->optional()->sentence(),
            'is_critic' => $user->role === 'critic',
        ];
    }

}
