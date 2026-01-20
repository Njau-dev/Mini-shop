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
}
