<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ReviewsController extends Controller
{
    public function index()
    {
        Log::info('List all reviews', [
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);
        return response()->json(Review::with(['user', 'film'])->get());
    }

    public function store(Request $request)
    {
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
    }

    public function show($id)
    {
        $review = Review::findOrFail($id);

        Log::info('Show review details', [
            'review_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json($review->load(['user', 'film']));
    }

    public function update(Request $request, $id)
    {
        $review = Review::findOrFail($id);

        $validated = $request->validate([
            'user_id' => 'required|exists:users,id',
            'film_id' => 'required|exists:films,id',
            'rating' => 'integer|min:1|max:10',
            'comment' => 'nullable|string',
            'is_critic' => 'boolean',
        ]);

        $review->update($validated);

        Log::info('Review updated', [
            'review_id' => $id,
            'user_id' => $request->user()?->id,
            'ip' => $request->ip(),
            'film_id' => $review->film_id,
            'rating' => $review->rating,
        ]);

        return response()->json($review);
    }

    public function destroy($id)
    {
        $review = Review::findOrFail($id);
        $review->delete();

        Log::info('Review deleted', [
            'review_id' => $id,
            'user_id' => request()->user()?->id,
            'ip' => request()->ip(),
        ]);

        return response()->json(null, 204);
    }
}
