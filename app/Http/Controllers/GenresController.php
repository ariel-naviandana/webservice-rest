<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class GenresController extends Controller
{
    public function index()
    {
        try {
            Log::info('List all genres', [
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);
            return response()->json(Genre::all());
        } catch (\Throwable $e) {
            Log::error('Genres index error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function store(Request $request)
    {
        try {
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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Genres store error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function show($id)
    {
        try {
            $genre = Genre::findOrFail($id);

            Log::info('Show genre details', [
                'genre_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json($genre);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Genre not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Genres show error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Genre not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Genres update error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $genre = Genre::findOrFail($id);
            $genre->delete();

            Log::info('Genre deleted', [
                'genre_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Genre not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Genres destroy error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function films($id)
    {
        try {
            $genre = Genre::with('films')->findOrFail($id);

            Log::info('List films by genre', [
                'genre_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json($genre->films);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Genre not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Genres films error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }
}
