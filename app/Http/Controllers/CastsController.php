<?php

namespace App\Http\Controllers;

use App\Models\Cast;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class CastsController extends Controller
{
    public function index()
    {
        try {
            Log::info('List all casts', [
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);
            return response()->json(Cast::all());
        } catch (\Throwable $e) {
            Log::error('Casts index error', [
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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Casts store error', [
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
            $cast = Cast::findOrFail($id);

            Log::info('Show cast details', [
                'cast_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json($cast);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cast not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Casts show error', [
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
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cast not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Casts update error', [
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
            $cast = Cast::findOrFail($id);
            $cast->delete();

            Log::info('Cast deleted', [
                'cast_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cast not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Casts destroy error', [
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
            $cast = Cast::with('films')->findOrFail($id);

            Log::info('List films by cast', [
                'cast_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json($cast->films);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Cast not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Casts films error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }
}
