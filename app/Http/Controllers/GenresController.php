<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;

class GenresController extends Controller
{
    public function index()
    {
        return response()->json(Genre::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name',
        ]);

        $genre = Genre::create($validated);

        return response()->json($genre, 201);
    }

    public function show($id)
    {
        $genre = Genre::findOrFail($id);
        return response()->json($genre);
    }

    public function update(Request $request, $id)
    {
        $genre = Genre::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|unique:genres,name,' . $id,
        ]);

        $genre->update($validated);

        return response()->json($genre);
    }

    public function destroy($id)
    {
        $genre = Genre::findOrFail($id);
        $genre->delete();

        return response()->json(null, 204);
    }

    public function films($id)
    {
        $genre = Genre::with('films')->findOrFail($id);
        return response()->json($genre->films);
    }

}
