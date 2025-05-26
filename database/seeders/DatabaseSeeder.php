<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Insert Users
        $users = [
            ['name' => 'John Smith', 'email' => 'john.smith@example.com', 'password' => Hash::make('password123'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Emma Wilson', 'email' => 'emma.wilson@example.com', 'password' => Hash::make('password123'), 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Michael Brown', 'email' => 'michael.brown@example.com', 'password' => Hash::make('password123'), 'role' => 'critic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sarah Davis', 'email' => 'sarah.davis@example.com', 'password' => Hash::make('password123'), 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'David Lee', 'email' => 'david.lee@example.com', 'password' => Hash::make('password123'), 'role' => 'critic', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laura Taylor', 'email' => 'laura.taylor@example.com', 'password' => Hash::make('password123'), 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Admin User', 'email' => 'admin@gmail.com', 'password' => Hash::make('admin123'), 'role' => 'admin', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Regular User', 'email' => 'user@gmail.com', 'password' => Hash::make('user123'), 'role' => 'user', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($users as $user) {
            DB::table('users')->insert($user);
        }

        // Insert Genres
        $genres = [
            ['name' => 'Action', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Drama', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Science Fiction', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Comedy', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Thriller', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Romance', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Adventure', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fantasy', 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($genres as $genre) {
            DB::table('genres')->insert($genre);
        }

        // Insert Casts
        $casts = [
            ['name' => 'Leonardo DiCaprio', 'birth_date' => '1974-11-11', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Kate Winslet', 'birth_date' => '1975-10-05', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Robert Downey Jr.', 'birth_date' => '1965-04-04', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Scarlett Johansson', 'birth_date' => '1984-11-22', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tom Hanks', 'birth_date' => '1956-07-09', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Meryl Streep', 'birth_date' => '1949-06-22', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Brad Pitt', 'birth_date' => '1963-12-18', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Angelina Jolie', 'birth_date' => '1975-06-04', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Christian Bale', 'birth_date' => '1974-01-30', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Natalie Portman', 'birth_date' => '1981-06-09', 'photo_url' => null, 'created_at' => now(), 'updated_at' => now()],
        ];

        foreach ($casts as $cast) {
            DB::table('casts')->insert($cast);
        }

        // Insert Films
        $films = [
            [
                'title' => 'Inception',
                'synopsis' => 'A skilled thief has the power to enter dreams and steal secrets. He is offered a chance at redemption by performing an impossible task: planting an idea in someone\'s mind.',
                'release_year' => 2010,
                'duration' => 148,
                'poster_url' => "https://res.cloudinary.com/dto6d9tbe/image/upload/v1748224272/film_posters/htefio0uoay43yqr7vmx.jpg",
                'director' => 'Christopher Nolan',
                'rating_avg' => 0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'genres' => ['Action', 'Science Fiction', 'Thriller'],
                'casts' => ['Leonardo DiCaprio', 'Natalie Portman'],
            ],
            [
                'title' => 'Titanic',
                'synopsis' => 'A young couple from different social classes fall in love aboard the ill-fated RMS Titanic during its tragic maiden voyage.',
                'release_year' => 1997,
                'duration' => 195,
                'poster_url' => "https://res.cloudinary.com/dto6d9tbe/image/upload/v1748224215/film_posters/gsvavd37scfsz1ytvizg.jpg",
                'director' => 'James Cameron',
                'rating_avg' => 0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'genres' => ['Romance', 'Drama'],
                'casts' => ['Leonardo DiCaprio', 'Kate Winslet'],
            ],
            [
                'title' => 'The Avengers',
                'synopsis' => 'Earth\'s mightiest heroes must come together to stop Loki and his alien army from enslaving humanity.',
                'release_year' => 2012,
                'duration' => 143,
                'poster_url' => "https://res.cloudinary.com/dto6d9tbe/image/upload/v1748224191/film_posters/bubdy32deoge0434c59o.jpg",
                'director' => 'Joss Whedon',
                'rating_avg' => 0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'genres' => ['Action', 'Adventure', 'Science Fiction'],
                'casts' => ['Robert Downey Jr.', 'Scarlett Johansson'],
            ],
            [
                'title' => 'Forrest Gump',
                'synopsis' => 'The story of a man with a low IQ who achieves great things in life, from athletics to war, while staying true to his love for his childhood friend.',
                'release_year' => 1994,
                'duration' => 142,
                'poster_url' => "https://res.cloudinary.com/dto6d9tbe/image/upload/v1748224172/film_posters/p4bbajw5ghaldhhdv7o1.jpg",
                'director' => 'Robert Zemeckis',
                'rating_avg' => 0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'genres' => ['Drama', 'Romance'],
                'casts' => ['Tom Hanks'],
            ],
            [
                'title' => 'The Dark Knight',
                'synopsis' => 'Batman faces the Joker, a criminal mastermind who seeks to create chaos in Gotham City.',
                'release_year' => 2008,
                'duration' => 152,
                'poster_url' => "https://res.cloudinary.com/dto6d9tbe/image/upload/v1748224159/film_posters/tooqo4xmqzpkcrjmitld.jpg",
                'director' => 'Christopher Nolan',
                'rating_avg' => 0,
                'total_reviews' => 0,
                'created_at' => now(),
                'updated_at' => now(),
                'genres' => ['Action', 'Thriller', 'Drama'],
                'casts' => ['Christian Bale'],
            ],
        ];

        foreach ($films as $film) {
            $filmId = DB::table('films')->insertGetId([
                'title' => $film['title'],
                'synopsis' => $film['synopsis'],
                'release_year' => $film['release_year'],
                'duration' => $film['duration'],
                'poster_url' => $film['poster_url'],
                'director' => $film['director'],
                'rating_avg' => $film['rating_avg'],
                'total_reviews' => $film['total_reviews'],
                'created_at' => $film['created_at'],
                'updated_at' => $film['updated_at'],
            ]);

            // Insert Film Genres
            $genreIds = DB::table('genres')->whereIn('name', $film['genres'])->pluck('id');
            foreach ($genreIds as $genreId) {
                DB::table('film_genre')->insert([
                    'film_id' => $filmId,
                    'genre_id' => $genreId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }

            // Insert Film Casts
            $castIds = DB::table('casts')->whereIn('name', $film['casts'])->pluck('id');
            foreach ($castIds as $castId) {
                DB::table('film_cast')->insert([
                    'film_id' => $filmId,
                    'cast_id' => $castId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        // Insert Reviews
        $reviews = [
            ['user_id' => 1, 'film_id' => 1, 'rating' => 8, 'comment' => 'Mind-bending plot with great visuals!', 'is_critic' => true],
            ['user_id' => 2, 'film_id' => 1, 'rating' => 7, 'comment' => 'Really enjoyed the concept, but a bit confusing.', 'is_critic' => false],
            ['user_id' => 3, 'film_id' => 2, 'rating' => 9, 'comment' => 'A timeless love story.', 'is_critic' => true],
            ['user_id' => 4, 'film_id' => 2, 'rating' => 6, 'comment' => 'Too long for my taste.', 'is_critic' => false],
            ['user_id' => 5, 'film_id' => 3, 'rating' => 8, 'comment' => 'Action-packed and fun!', 'is_critic' => true],
            ['user_id' => 6, 'film_id' => 3, 'rating' => 7, 'comment' => 'Great team dynamics.', 'is_critic' => false],
            ['user_id' => 1, 'film_id' => 4, 'rating' => 9, 'comment' => 'Heartwarming and inspiring.', 'is_critic' => true],
            ['user_id' => 2, 'film_id' => 4, 'rating' => 8, 'comment' => 'Loved Forrest’s journey.', 'is_critic' => false],
            ['user_id' => 3, 'film_id' => 5, 'rating' => 10, 'comment' => 'The Joker was phenomenal!', 'is_critic' => true],
            ['user_id' => 4, 'film_id' => 5, 'rating' => 9, 'comment' => 'Intense and gripping.', 'is_critic' => false],
        ];

        foreach ($reviews as $review) {
            DB::table('reviews')->insert([
                'user_id' => $review['user_id'],
                'film_id' => $review['film_id'],
                'rating' => $review['rating'],
                'comment' => $review['comment'],
                'is_critic' => $review['is_critic'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Update film rating and total reviews
            $film = DB::table('films')->where('id', $review['film_id'])->first();
            $newTotalReviews = $film->total_reviews + 1;
            $newRatingAvg = (($film->rating_avg * $film->total_reviews) + $review['rating']) / $newTotalReviews;

            DB::table('films')->where('id', $review['film_id'])->update([
                'total_reviews' => $newTotalReviews,
                'rating_avg' => round($newRatingAvg, 2),
            ]);
        }
    }
}
