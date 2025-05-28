<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CastsController extends Controller
{
    public function index()
    {
        Log::info('List all casts', [
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);
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

        Log::info('Cast created', [
            'cast_id' => $cast->id,
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
            'name' => $cast->name,
        ]);

        return response()->json($cast, 201);
    }

    public function show($id)
    {
        $cast = Cast::findOrFail($id);

        Log::info('Show cast details', [
            'cast_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

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

        Log::info('Cast updated', [
            'cast_id' => $id,
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
            'name' => $cast->name,
        ]);

        return response()->json($cast);
    }

    public function destroy($id)
    {
        $cast = Cast::findOrFail($id);
        $cast->delete();

        Log::info('Cast deleted', [
            'cast_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json(null, 204);
    }

    public function films($id)
    {
        $cast = Cast::with('films')->findOrFail($id);

        Log::info('List films by cast', [
            'cast_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json($cast->films);
    }
}
