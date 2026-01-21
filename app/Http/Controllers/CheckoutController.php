<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use App\Services\OrderService;

class CheckoutController extends Controller
{
    public function __construct(
        protected CartService $cartService,
        protected OrderService $orderService
    ) {}

    /**
     * Display checkout page
     */
    public function index()
    {
        if ($this->cartService->isEmpty()) {
            return redirect()
                ->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        $cart = $this->cartService->getItems();
        $totals = $this->cartService->getTotals();

        return view('checkout.index', [
            'cart' => $cart,
            'total' => $totals['total'],
            'itemCount' => count($cart),
        ]);
    }

    /**
     * Process checkout and create order
     */
    public function checkout(CheckoutRequest $request)
    {
        try {
            $order = $this->orderService->checkout($request->validated());

            return redirect()
                ->route('orders.show', $order)
                ->with('success', 'Order placed successfully!');
        } catch (\Exception $e) {
            return back()->with(
                'error',
                'There was an error processing your order. Please try again.'
            );
        }
    }
}
