<?php

namespace App\Http\Controllers;

use App\Http\Requests\AddToCartRequest;
use App\Http\Requests\UpdateCartRequest;
use App\Services\CartService;

class CartController extends Controller
{
    public function __construct(
        protected CartService $cartService
    ) {}

    public function index()
    {
        $cart = $this->cartService->getItems();
        $totals = $this->cartService->getTotals();

        return view('cart.index', [
            'cart' => $cart,
            'total' => $totals['total'],
        ]);
    }

    public function add(AddToCartRequest $request, int $id)
    {
        try {
            $this->cartService->addItem(
                $id,
                $request->validatedQuantity()
            );

            return back()->with('success', 'Product added to cart successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(UpdateCartRequest $request, int $id)
    {
        try {
            $this->cartService->updateQuantity(
                $id,
                $request->validatedQuantity()
            );

            return back()->with('success', 'Cart updated successfully!');
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function remove(int $id)
    {
        $this->cartService->removeItem($id);

        return back()->with('success', 'Product removed from cart successfully!');
    }

    public function clear()
    {
        $this->cartService->clear();

        return back()->with('success', 'Cart cleared successfully!');
    }
}
