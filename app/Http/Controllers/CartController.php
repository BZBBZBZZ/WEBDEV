<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Tampilkan halaman cart
    public function index()
    {
        $cartItems = Auth::user()->carts()->with('product.category')->get();
        
        $total = $cartItems->sum(function ($item) {
            return $item->product->getDiscountedPrice() * $item->quantity;
        });

        return view('cart.index', compact('cartItems', 'total'));
    }

    // Tambah produk ke cart
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1'
        ]);

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->first();

        if ($existingCart) {
            $existingCart->increment('quantity', $request->quantity);
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $request->product_id,
                'quantity' => $request->quantity
            ]);
        }

        // ✅ REDIRECT KE PREVIOUS PAGE (product detail page)
        return redirect()->back()
            ->with('success', 'Product added to cart!');
    }

    // Update quantity
    public function update(Request $request, Cart $cart)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1'
        ]);

        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->update(['quantity' => $request->quantity]);

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated!');
    }

    // Hapus item dari cart
    public function destroy(Cart $cart)
    {
        if ($cart->user_id !== Auth::id()) {
            abort(403);
        }

        $cart->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Item removed from cart!');
    }

    // Clear all cart
    public function clear()
    {
        Auth::user()->carts()->delete();

        return redirect()->route('cart.index')
            ->with('success', 'Cart cleared successfully!');
    }
}
