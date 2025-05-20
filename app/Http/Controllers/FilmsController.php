<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    public function index()
    {
        return response()->json(Film::with(['genres', 'characters', 'reviews'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'synopsis' => 'nullable|string',
            'release_year' => 'required|integer|min:1900|max:'.(date('Y') + 1),
            'duration' => 'required|integer|min:1',
            'poster_url' => 'nullable|url',
            'director' => 'nullable|string|max:255',
            'cast_ids' => 'nullable|array',
            'cast_ids.*' => 'exists:casts,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $film = Film::create([
            'title' => $validated['title'],
            'synopsis' => $validated['synopsis'],
            'release_year' => $validated['release_year'],
            'duration' => $validated['duration'],
            'poster_url' => $validated['poster_url'],
            'director' => $validated['director'],
            'rating_avg' => 0,
            'total_reviews' => 0,
        ]);

        if (!empty($validated['cast_ids'])) {
            $castData = array_fill_keys($validated['cast_ids'], ['character' => 'Unknown']);
            $film->characters()->attach($castData);
        }

        if (!empty($validated['genre_ids'])) {
            $film->genres()->attach($validated['genre_ids']);
        }

        return response()->json($film->load(['genres', 'characters', 'reviews']), 201);
    }

    public function show($id)
    {
        $film = Film::findOrFail($id);
        return response()->json($film->load(['genres', 'characters', 'reviews']));
    }

    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $validated = $request->validate([
            'title' => 'string|max:255',
            'synopsis' => 'nullable|string',
            'release_year' => 'integer|min:1900|max:'.(date('Y') + 1),
            'duration' => 'integer|min:1',
            'poster_url' => 'nullable|url',
            'director' => 'nullable|string|max:255',
            'cast_ids' => 'nullable|array',
            'cast_ids.*' => 'exists:casts,id',
            'genre_ids' => 'nullable|array',
            'genre_ids.*' => 'exists:genres,id',
        ]);

        $film->update(array_filter($validated, function ($key) {
            return in_array($key, ['title', 'synopsis', 'release_year', 'duration', 'poster_url', 'director']);
        }, ARRAY_FILTER_USE_KEY));

        if (isset($validated['cast_ids'])) {
            $castData = array_fill_keys($validated['cast_ids'], ['character' => 'Unknown']);
            $film->characters()->sync($castData);
        }

        if (isset($validated['genre_ids'])) {
            $film->genres()->sync($validated['genre_ids']);
        }

        return response()->json($film->load(['genres', 'characters', 'reviews']));
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);
        $film->delete();

        return response()->json(null, 204);
    }

    public function addCast(Request $request)
    {
        $film = Film::findOrFail($request->id);

        $request->validate([
            'castId' => 'required|exists:casts,id',
            'character' => 'required|string',
        ]);
        $film->characters()->attach($request->castId, ['character' => $request->character]);

        return response()->json($film->load(['genres', 'characters', 'reviews']));
    }

    public function addGenre(Request $request)
    {
        $film = Film::findOrFail($request->id);

        $request->validate([
            'genreId' => 'required|exists:genres,id',
        ]);
        $film->genres()->attach($request->genreId);

        return response()->json($film->load(['genres', 'characters', 'reviews']));
    }
}
