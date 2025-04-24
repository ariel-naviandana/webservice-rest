<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Faker\Factory as Faker;
use DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');

        for ($x = 1; $x <= 10; $x++) {
            DB::table('users')->insert([
                'name' => $faker->name,
                'email' => $faker->unique()->safeEmail,
                'password' => bcrypt('password'),
                'role' => $faker->randomElement(['admin', 'user', 'critic']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($x = 1; $x <= 10; $x++) {
            DB::table('genres')->insert([
                'name' => ucfirst($faker->unique()->word),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($x = 1; $x <= 20; $x++) {
            DB::table('casts')->insert([
                'name' => $faker->name,
                'birth_date' => $faker->optional()->date(),
                'photo_url' => $faker->imageUrl(200, 300, 'people'),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        for ($x = 1; $x <= 15; $x++) {
            $filmId = DB::table('films')->insertGetId([
                'title' => $faker->unique()->sentence(3),
                'synopsis' => $faker->paragraph(),
                'release_year' => $faker->year(),
                'duration' => $faker->numberBetween(80, 180),
                'poster_url' => $faker->imageUrl(300, 450, 'movies'),
                'director' => $faker->name(),
                'rating_avg' => 0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $genreIds = DB::table('genres')->inRandomOrder()->take(rand(1, 3))->pluck('id');
            foreach ($genreIds as $genreId) {
                DB::table('film_genre')->insert([
                    'film_id' => $filmId,
                    'genre_id' => $genreId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            $castIds = DB::table('casts')->inRandomOrder()->take(rand(2, 5))->pluck('id');
            foreach ($castIds as $castId) {
                DB::table('film_cast')->insert([
                    'film_id' => $filmId,
                    'cast_id' => $castId,
                    'character' => $faker->optional()->name,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        for ($x = 1; $x <= 30; $x++) {
            $userId = DB::table('users')->inRandomOrder()->first()->id;
            $filmId = DB::table('films')->inRandomOrder()->first()->id;
            $rating = $faker->numberBetween(1, 10);

            DB::table('reviews')->insert([
                'user_id' => $userId,
                'film_id' => $filmId,
                'rating' => $rating,
                'comment' => $faker->optional()->sentence(),
                'is_critic' => $userId % 2 === 0,
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            $film = DB::table('films')->where('id', $filmId)->first();
            $newTotalReviews = $film->total_reviews + 1;
            $newRatingAvg = (($film->rating_avg * $film->total_reviews) + $rating) / $newTotalReviews;

            DB::table('films')->where('id', $filmId)->update([
                'total_reviews' => $newTotalReviews,
                'rating_avg' => round($newRatingAvg, 2),
            ]);
        }
    }
}
