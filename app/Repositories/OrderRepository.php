<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;

class OrderRepository
{
    public function createOrder(array $data): Order
    {
        return Order::create($data);
    }

    public function addOrderItem(int $orderId, array $item): void
    {
        OrderItem::create([
            'order_id' => $orderId,
            'product_id' => $item['product_id'],
            'quantity' => $item['quantity'],
            'price' => $item['price'],
        ]);
    }

    public function reduceStock(array $items): void
    {
        foreach ($items as $item) {
            Product::where('id', $item['product_id'])
                ->decrement('stock', $item['quantity']);
        }
    }

    public function getOrdersByUserId(int $userId)
    {
        return Order::where('user_id', $userId)
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getUserOrderById(Order $order)
    {
        return $order->load('items.product.category');
    }

    public function getAllOrdersForAdmin()
    {
        return Order::with(['user', 'items.product'])
            ->latest()
            ->paginate(10);
    }

    public function getAdminOrderById(Order $order)
    {
        return $order->load(['user', 'items.product']);
    }

    public function updateOrderStatus(Order $order, string $status): void
    {
        $order->update(['status' => $status]);
    }
}
