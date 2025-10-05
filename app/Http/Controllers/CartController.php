<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function add(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate quantity
        $quantity = $request->input('quantity', 1);

        if ($quantity > $product->stock) {
            return back()->with('error', 'Requested quantity exceeds available stock.');
        }

        // Get cart from session
        $cart = session()->get('cart', []);

        // If product already in cart, update quantity
        if (isset($cart[$id])) {
            $newQuantity = $cart[$id]['quantity'] + $quantity;

            if ($newQuantity > $product->stock) {
                return back()->with('error', 'Cannot add more items. Stock limit reached.');
            }

            $cart[$id]['quantity'] = $newQuantity;
        } else {
            // Add new product to cart
            $cart[$id] = [
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'category' => $product->category->name,
                'stock' => $product->stock
            ];
        }

        // Save cart to session
        session()->put('cart', $cart);

        return back()->with('success', 'Product added to cart successfully!');
    }

    public function index()
    {
        $cart = session()->get('cart', []);
        $total = 0;

        foreach ($cart as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function update(Request $request, $id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            $product = Product::findOrFail($id);
            $quantity = $request->input('quantity', 1);

            if ($quantity > $product->stock) {
                return back()->with('error', 'Requested quantity exceeds available stock.');
            }

            $cart[$id]['quantity'] = $quantity;
            session()->put('cart', $cart);

            return back()->with('success', 'Cart updated successfully!');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    public function remove($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);
            session()->put('cart', $cart);

            return back()->with('success', 'Product removed from cart successfully!');
        }

        return back()->with('error', 'Product not found in cart.');
    }

    public function clear()
    {
        session()->forget('cart');

        return back()->with('success', 'Cart cleared successfully!');
    }
}
