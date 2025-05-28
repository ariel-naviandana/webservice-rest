<?php

namespace App\Http\Controllers;

use App\Models\Film;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class FilmsController extends Controller
{
    public function index()
    {
        try {
            Log::info('List all films', [
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);
            return response()->json(Film::with(['genres', 'characters', 'reviews'])->get());
        } catch (\Throwable $e) {
            Log::error('Films index error', [
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
                $film->characters()->sync($validated['cast_ids']);
            }
            if (!empty($validated['genre_ids'])) {
                $film->genres()->sync($validated['genre_ids']);
            }

            Log::info('Film created', [
                'film_id' => $film->id,
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'title' => $film->title,
            ]);

            return response()->json($film->load(['genres', 'characters', 'reviews']), 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Films store error', [
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
            $film = Film::findOrFail($id);

            Log::info('Show film details', [
                'film_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json($film->load(['genres', 'characters', 'reviews']));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Film not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Films show error', [
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
                $film->characters()->sync($validated['cast_ids']);
            }
            if (isset($validated['genre_ids'])) {
                $film->genres()->sync($validated['genre_ids']);
            }

            Log::info('Film updated', [
                'film_id' => $id,
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'title' => $film->title,
            ]);

            return response()->json($film->load(['genres', 'characters', 'reviews']));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Film not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Films update error', [
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
            $film = Film::findOrFail($id);
            $film->delete();

            Log::info('Film deleted', [
                'film_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Film not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Films destroy error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function addCast(Request $request)
    {
        try {
            $film = Film::findOrFail($request->id);

            $request->validate([
                'castId' => 'required|exists:casts,id',
            ]);
            $film->characters()->attach($request->castId);

            Log::info('Cast added to film', [
                'film_id' => $film->id,
                'cast_id' => $request->castId,
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
            ]);

            return response()->json($film->load(['genres', 'characters', 'reviews']));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Film not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Films addCast error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }

    public function addGenre(Request $request)
    {
        try {
            $film = Film::findOrFail($request->id);

            $request->validate([
                'genreId' => 'required|exists:genres,id',
            ]);
            $film->genres()->attach($request->genreId);

            Log::info('Genre added to film', [
                'film_id' => $film->id,
                'genre_id' => $request->genreId,
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
            ]);

            return response()->json($film->load(['genres', 'characters', 'reviews']));
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Film not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Films addGenre error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => $request->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }
}
