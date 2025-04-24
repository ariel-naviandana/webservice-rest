<?php

namespace Database\Factories;

use App\Models\Cast;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Cast>
 */
class CastFactory extends Factory
{
    protected $model = Cast::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'birth_date' => $this->faker->optional()->date(),
            'photo_url' => $this->faker->imageUrl(200, 300, 'people'),
        ];
    }

}
