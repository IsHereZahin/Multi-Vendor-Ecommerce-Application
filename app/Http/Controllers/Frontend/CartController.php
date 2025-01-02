<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Cart;
use App\Models\Coupon;
use Carbon\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();
        $total = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });
        $coupon = session('coupon', null);

        return view('frontend.cart.index', compact('cartItems', 'total', 'coupon'));
    }

    // Apply Coupon to Cart
    public function CouponApply(Request $request)
    {
        // Clear existing coupon session if any
        if (Session::has('coupon')) {
            Session::forget('coupon');
        }

        // Validate coupon code
        $validated = $request->validate([
            'coupon_name' => 'required|string',
        ]);

        $couponCode = $validated['coupon_name'];

        // Check if the coupon exists and is valid
        $coupon = Coupon::where('code', $couponCode)
            ->where('expiry_date', '>=', Carbon::now()->format('Y-m-d'))
            ->first();

        if (!$coupon) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid or expired coupon code!',
            ]);
        }

        // Get cart items
        $cartItems = Cart::where('user_id', auth()->id())->get();

        if ($cartItems->isEmpty()) {
            return response()->json([
                'error' => true,
                'message' => 'Your cart is empty. Add items before applying a coupon!',
            ]);
        }

        // Calculate cart total
        $cartTotal = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });

        if ($cartTotal <= 0) {
            return response()->json([
                'error' => true,
                'message' => 'Invalid cart total. Cannot apply coupon.',
            ]);
        }

        // Calculate discount and total amount
        $discountAmount = round($cartTotal * $coupon->discount / 100);
        $totalAmount = round($cartTotal - $discountAmount);

        // Store coupon details in session
        Session::put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
        ]);

        return response()->json([
            'validity' => true,
            'message' => 'Coupon applied successfully!',
            'discount_percent' => $coupon->discount,
            'discount_amount' => $discountAmount,
            'total_amount' => $totalAmount,
            'cartTotal' => $cartTotal,
            'coupon_code' => $coupon->code,
        ]);
    }

    // Remove Coupon from Cart
    public function CouponRemove()
    {
        // Forget the coupon and return updated cart data
        Session::forget('coupon');

        return response()->json([
            'cartItems' => Cart::where('user_id', auth()->id())->get(),
            'count' => Cart::where('user_id', auth()->id())->count(),
        ]);
    }

    // Add product to the cart
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
        } else {
            // If no such item exists, create a new cart entry
            Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $validated['product_id'],
                'quantity' => $validated['quantity'],
                'size' => $validated['size'],
                'color' => $validated['color'],
            ]);
        }

        // After adding the item, apply the coupon if it's available
        if (Session::has('coupon')) {
            $this->CouponApply(new Request(['coupon_name' => Session::get('coupon')['code']]));
        }

        $cartCount = Cart::where('user_id', auth()->id())->count();

        return response()->json([
            'success' => true,
            'message' => 'Item added to cart successfully!',
            'count' => $cartCount
        ]);
    }

    // Get cart data including updated total and items
    public function getCartData()
    {
        $cartItems = Cart::where('user_id', auth()->id())->get();

        $total = $cartItems->sum(function ($item) {
            return ($item->product->selling_price - $item->product->discount_price) * $item->quantity;
        });

        // Apply coupon if exists
        if (Session::has('coupon')) {
            $coupon = Session::get('coupon');
            $totalAmount = $coupon['total_amount'];
        } else {
            $totalAmount = $total;
            $coupon = null;
        }

        return response()->json([
            'cartItems' => $cartItems,
            'total' => number_format($total, 2),
            'count' => $cartItems->count(),
            'totalAmount' => number_format($totalAmount, 2),
            'coupon' => $coupon,
        ]);
    }

    // Remove item from cart
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

        // After removal, apply coupon again if necessary
        if (Session::has('coupon')) {
            $this->CouponApply(new Request(['coupon_name' => Session::get('coupon')['code']]));
        }

        // Return a success response
        return response()->json(['success' => 'Item removed from cart successfully!']);
    }

    // Clear the cart
    public function clearCart()
    {
        // Ensure the user is authenticated
        if (auth()->check()) {
            // Remove all cart items for the authenticated user
            Cart::where('user_id', auth()->id())->delete();
        }

        // Clear coupon session
        Session::forget('coupon');

        // Redirect back to the cart page with a success message
        return redirect()->route('cart.index')->with('success', 'Your cart has been cleared!');
    }

    // Increment cart item quantity
    public function CartIncrement($id)
    {
        $cartItem = Cart::where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        $product = $cartItem->product;

        if ($cartItem->quantity < $product->product_qty) {
            $cartItem->increment('quantity');
            // After increment, apply coupon
            if (Session::has('coupon')) {
                $this->CouponApply(new Request(['coupon_name' => Session::get('coupon')['code']]));
            }
            return response()->json(['success' => 'Quantity increased successfully.']);
        }

        return response()->json(['error' => 'Quantity exceeds available stock.'], 400);
    }

    // Decrement cart item quantity
    public function CartDecrement($id)
    {
        $cartItem = Cart::where('id', $id)->first();

        if (!$cartItem) {
            return response()->json(['error' => 'Cart item not found.'], 404);
        }

        if ($cartItem->quantity > 1) {
            $cartItem->decrement('quantity');
            // After decrement, apply coupon
            if (Session::has('coupon')) {
                $this->CouponApply(new Request(['coupon_name' => Session::get('coupon')['code']]));
            }
            return response()->json(['success' => 'Quantity decreased successfully.']);
        }

        return response()->json(['error' => 'Quantity cannot be less than 1.'], 400);
    }

    // Update cart item attributes like color or size
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
            // After updating, apply coupon
            if (Session::has('coupon')) {
                $this->CouponApply(new Request(['coupon_name' => Session::get('coupon')['code']]));
            }
            return response()->json([
                'success' => true,
                'color' => $cartItem->color,
                'size' => $cartItem->size,
            ]);
        }

        return response()->json(['success' => false]);
    }
}
