<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;

class FilmsController extends Controller
{
    public function index()
    {
        return response()->json(Film::with(['genres', 'casts', 'reviews'])->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string',
            'synopsis' => 'nullable|string',
            'release_year' => 'required|integer',
            'duration' => 'required|integer',
            'poster_url' => 'nullable|url',
            'director' => 'nullable|string',
        ]);

        $film = Film::create($validated);

        return response()->json($film, 201);
    }

    public function show($id)
    {
        $film = Film::findOrFail($id);
        return response()->json($film->load(['genres', 'casts', 'reviews']));
    }

    public function update(Request $request, $id)
    {
        $film = Film::findOrFail($id);

        $validated = $request->validate([
            'title' => 'string',
            'synopsis' => 'nullable|string',
            'release_year' => 'integer',
            'duration' => 'integer',
            'poster_url' => 'nullable|url',
            'director' => 'nullable|string',
        ]);

        $film->update($validated);

        return response()->json($film);
    }

    public function destroy($id)
    {
        $film = Film::findOrFail($id);
        $film->delete();

        return response()->json(null, 204);
    }
}
