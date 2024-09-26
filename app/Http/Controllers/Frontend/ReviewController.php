<?php
// app/Http/Controllers/ReviewController.php

namespace App\Http\Controllers\Frontend;
use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'review' => 'required|string|max:1000',
            'rating' => 'required|integer|min:1|max:5',
        ]);

        $review = Review::create([
            'product_id' => $request->product_id,
            'user_id' => Auth::id(),
            'review' => $request->review,
            'rating' => $request->rating,
        ]);

        return response()->json(['message' => 'Review submitted successfully!', 'review' => $review], 201);
    }
}
