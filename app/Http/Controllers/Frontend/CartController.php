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

    public function removeItem($id)
    {
        // Locate the cart item for the logged-in user
        $cartItem = Cart::where('id', $id)
            ->where('user_id', auth()->id())
            ->first();

        // If the item is not found, return an error message
        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.']);
        }

        // Remove the item from the cart
        $cartItem->delete();

        // Return a success response
        return response()->json(['success' => 'Item removed from cart successfully!']);
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

    public function updateQuantity(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|min:1',
        ]);

        $product = Product::find($validated['product_id']);
        $cartItem = Cart::where('product_id', $validated['product_id'])->first();

        if (!$product) {
            return response()->json(['success' => false, 'message' => 'Product not found.']);
        }

        if ($validated['quantity'] > $product->product_qty) {
            return response()->json(['success' => false, 'message' => 'Quantity exceeds available stock.']);
        }

        if ($cartItem) {
            $cartItem->quantity = $validated['quantity'];
            $cartItem->save();

            return response()->json([
                'success' => true,
                'message' => 'Quantity updated successfully.',
                'quantity' => $cartItem->quantity,
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Cart item not found.',
            ]);
        }
    }
    /**
     * Increment the cart item quantity.
     */
    public function CartIncrement($id)
    {
        $cartItem = Cart::where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        $product = $cartItem->product;

        if ($cartItem->quantity < $product->product_qty) {
            $cartItem->increment('quantity');
            return response()->json(['success' => 'Quantity increased successfully.']);
        }

        return response()->json(['error' => 'Quantity exceeds available stock.'], 400);
    }
    /**
     * Decrement the cart item quantity.
     */
    public function CartDecrement($id)
    {
        $cartItem = Cart::where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
            return response()->json(['success' => 'Quantity decreased successfully.']);
        }

        return response()->json(['error' => 'Quantity cannot be less than 1.'], 400);
    }

    public function update(Request $request, $id)
    {
        $cartItem = Cart::findOrFail($id);

        $updated = false;

        if ($request->has('color')) {
            $cartItem->update([
                'color' => $request->input('color'),
            ]);
            $updated = true;
        }

        if ($request->has('size')) {
            $cartItem->update([
                'size' => $request->input('size'),
            ]);
            $updated = true;
        }

        if ($updated) {
            return response()->json([
                'success' => true,
                'color' => $cartItem->color,
                'size' => $cartItem->size,
            ]);
        }

        return response()->json(['success' => false]);
    }
}
