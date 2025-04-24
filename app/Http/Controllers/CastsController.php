<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use Illuminate\Http\Request;

class CastsController extends Controller
{
    public function index()
    {
        return response()->json(Cast::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|url',
        ]);

        $cast = Cast::create($validated);

        return response()->json($cast, 201);
    }

    public function show($id)
    {
        $cast = Cast::findOrFail($id);
        return response()->json($cast);
    }

    public function update(Request $request, $id)
    {
        $cast = Cast::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string',
            'birth_date' => 'nullable|date',
            'photo_url' => 'nullable|url',
        ]);

        $cast->update($validated);

        return response()->json($cast);
    }

    public function destroy($id)
    {
        $cast = Cast::findOrFail($id);
        $cast->delete();

        return response()->json(null, 204);
    }

    public function films($id)
    {
        $cast = Cast::with('films')->findOrFail($id);
        return response()->json($cast->films);
    }
}
