<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\OrderRepository;
use Illuminate\Support\Facades\Auth;

class OrderService
{
    public function __construct(
        protected OrderRepository $orders,
        protected CartService $cartService
    ) {}

    public function checkout(array $shippingData)
    {
        if ($this->cartService->isEmpty()) {
            throw new \Exception('Cart is empty');
        }

        $cart = $this->cartService->getItems();
        $totals = $this->cartService->getTotals();

        $order = $this->orders->createOrder([
            'user_id' => Auth::id(),
            'total' => $totals['total'],
            'shipping_name' => $shippingData['shipping_name'],
            'shipping_address' => $shippingData['shipping_address'],
            'shipping_city' => $shippingData['shipping_city'],
            'shipping_phone' => $shippingData['shipping_phone'],
            'status' => 'pending',
        ]);

        foreach ($cart as $item) {
            $this->orders->addOrderItem($order->id, $item);

            $this->orders->reduceStock($cart);
        }

        $this->cartService->clear();

        return $order;
    }
}
