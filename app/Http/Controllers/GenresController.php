<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class GenresController extends Controller
{
    public function index()
    {
        Log::info('List all genres', [
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);
        return response()->json(Genre::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name',
        ]);

        $genre = Genre::create($validated);

        Log::info('Genre created', [
            'genre_id' => $genre->id,
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
            'name' => $genre->name,
        ]);

        return response()->json($genre, 201);
    }

    public function show($id)
    {
        $genre = Genre::findOrFail($id);

        Log::info('Show genre details', [
            'genre_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json($genre);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name,' . $id,
        ]);

        $genre->update($validated);

        Log::info('Genre updated', [
            'genre_id' => $id,
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
            'name' => $genre->name,
        ]);

        return response()->json($genre);
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        Log::info('Genre deleted', [
            'genre_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json(null, 204);
    }

    public function films($id)
    {
        $genre = Genre::with('films')->findOrFail($id);

        Log::info('List films by genre', [
            'genre_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json($genre->films);
    }
}
