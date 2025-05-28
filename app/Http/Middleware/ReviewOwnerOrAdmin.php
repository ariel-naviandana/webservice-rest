<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Review;

class ReviewOwnerOrAdmin
{
    public function handle(Request $request, Closure $next)
    {
        $reviewId = $request->route('id');
        $review = Review::find($reviewId);

        if (!$review) {
            return response()->json(['error' => 'Review not found'], 404);
        }

        $user = $request->user();

        if ($user->id !== $review->user_id && $user->role !== 'admin') {
            return response()->json(['error' => 'Unauthorized'], 403);
        }

        return $next($request);
    }
}
