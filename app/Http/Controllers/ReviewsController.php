<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\ValidationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ReviewsController extends Controller
{
    public function index()
    {
        try {
            Log::info('List all reviews', [
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);
            return response()->json(Review::with(['user', 'film'])->get());
        } catch (\Throwable $e) {
            Log::error('Reviews index error', [
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
                'user_id' => 'required|exists:users,id',
                'film_id' => 'required|exists:films,id',
                'rating' => 'required|integer|min:1|max:10',
                'comment' => 'nullable|string',
                'is_critic' => 'boolean',
            ]);

            $review = Review::create($validated);

            Log::info('Review created', [
                'review_id' => $review->id,
                'user_id' => $request->user()?->id,
                'ip' => $request->ip(),
                'film_id' => $review->film_id,
                'rating' => $review->rating,
            ]);

            return response()->json($review, 201);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (\Throwable $e) {
            Log::error('Reviews store error', [
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
            $review = Review::findOrFail($id);

            Log::info('Show review details', [
                'review_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json($review->load(['user', 'film']));
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Review not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Reviews show error', [
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
            $review = Review::findOrFail($id);

            $validated = $request->validate([
                'rating' => 'integer|min:1|max:10',
                'comment' => 'nullable|string',
                'is_critic' => 'boolean',
            ]);

            $review->update($validated);

            Log::info('Review updated', [
                'review_id' => $id,
                'ip' => $request->ip(),
                'rating' => $review->rating,
            ]);

            return response()->json($review);
        } catch (ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed.',
                'errors' => $e->errors()
            ], 422);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Review not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Reviews update error', [
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
            $review = Review::findOrFail($id);
            $review->delete();

            Log::info('Review deleted', [
                'review_id' => $id,
                'user_id' => request()->user()?->id,
                'ip' => request()->ip(),
            ]);

            return response()->json(null, 204);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Review not found.'], 404);
        } catch (\Throwable $e) {
            Log::error('Reviews destroy error', [
                'msg' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'ip' => request()->ip(),
            ]);
            return response()->json(['message' => 'Server error.'], 500);
        }
    }
}
