<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function addToCart(Request $request)
    {
        if (!auth()->check()) {
            return response()->json(['success' => false, 'message' => 'You must be logged in to add items to the cart.']);
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            'size' => 'nullable|string|not_in:--Choose Size--',
            'color' => 'nullable|string|not_in:--Choose Color--',
        ]);

        $product = Product::find($validated['product_id']);

        // Ensure quantity does not exceed available stock
        if ($validated['quantity'] > $product->product_qty) {
            return response()->json(['success' => false, 'message' => 'Quantity exceeds available stock.']);
        }

        // Check if the user already has this product in the cart with the same size and color
        $existingCartItem = Cart::where('user_id', auth()->id())
            ->where('product_id', $validated['product_id'])
            ->where('size', $validated['size'])
            ->where('color', $validated['color'])
            ->first();

        if ($existingCartItem) {
            // If item with the same size and color exists, update the quantity
            $existingCartItem->quantity += $validated['quantity'];
            $existingCartItem->save();

            return response()->json(['success' => true, 'message' => 'Item quantity updated in cart!']);
        } else {
            // If no such item exists, create a new cart entry
            $cart = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'size' => $validated['size'],
                'color' => $validated['color'],
            ]);

            return response()->json(['success' => true, 'message' => 'Item added to cart successfully!']);
        }
    }

    public function getCartData()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        $total = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });

        return response()->json([
            'cartItems' => $cartItems,
            'total' => number_format($total, 2),
            'count' => $cartItems->count(),
        ]);
    }

    // Remove item from cart
    public function removeItem($id)
    {
        $cartItem = Cart::where('id', $id)
                        ->where('user_id', auth()->id())
                        ->first();

        if (!$cartItem) {
            return response()->json(['success' => false, 'message' => 'Cart item not found.']);
        }

        $cartItem->delete();
        return redirect()->back()->with(['success' => true, 'message' => 'Item removed from cart successfully!']);
    }

    // Clear cart
    public function clearCart()
    {
        // Ensure the user is authenticated
        if (auth()->check()) {
            // Remove all cart items for the authenticated user
            Cart::where('user_id', auth()->id())->delete();
        }

        // Redirect back to the cart page with a success message
        return redirect()->route('cart.index')->with('success', 'Your cart has been cleared!');
    }

    // Display cart
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        return view('frontend.cart.index', compact('cartItems'));
    }
}
