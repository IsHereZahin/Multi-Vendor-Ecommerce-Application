<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Http\Request;

class WishlistController extends Controller
{
    public function index()
    {
        $wishlistItems = Wishlist::where('user_id', auth()->id())->with('product')->get();
        return view('frontend.wishlist.index', compact('wishlistItems'));
    }

    public function toggleWishlist($productId)
    {
        try {
            if (!auth()->check()) {
                return response()->json(['error' => 'Please log in to manage your wishlist.'], 401);
            }

            $userId = auth()->id();
            $wishlistItem = Wishlist::where('user_id', $userId)->where('product_id', $productId)->first();

            if ($wishlistItem) {
                $wishlistItem->delete();
                $message = 'Product removed from wishlist.';
                $isRemoved = true;
            } else {
                Wishlist::create([
                    'user_id' => $userId,
                    'product_id' => $productId,
                ]);
                $message = 'Product added to wishlist.';
                $isRemoved = false;
            }

            $count = Wishlist::where('user_id', $userId)->count();

            return response()->json([
                'success' => $message,
                'isRemoved' => $isRemoved,
                'count' => $count,
            ]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'An error occurred while updating your wishlist.']);
        }
    }
}
