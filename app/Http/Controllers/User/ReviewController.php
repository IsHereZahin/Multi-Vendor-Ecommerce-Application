<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Review;
use Illuminate\Http\Request;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'comment' => 'required|string|max:500',
            'rating' => 'required|integer|between:1,5',
        ]);

        $existingReview = Review::where('product_id', $request->product_id)
            ->where('user_id', $request->user_id)
            ->first();

        if ($existingReview) {
            return redirect()->back()->with([
                'message' => 'You have already submitted a review for this product.',
                'alert-type' => 'warning'
            ]);
        }

        // Create a new review
        Review::create([
            'product_id' => $request->product_id,
            'user_id' => $request->user_id,
            'vendor_id' => $request->vendor_id,
            'comment' => $request->comment,
            'rating' => $request->rating,
            'status' => false,
        ]);

        return redirect()->back()->with([
            'message' => 'Your review has been submitted successfully!',
            'alert-type' => 'success'
        ]);
    }
}
