<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateOrderRequest;
use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}

    public function index()
    {
        $orders = $this->orderService->getAdminOrders();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        $order = $this->orderService->getAdminOrderById($order);

        return view('admin.orders.show', compact('order'));
    }

    public function update(UpdateOrderRequest $request, Order $order)
    {
        $this->orderService->updateOrderStatus($order, $request->status);

        return redirect()->route('admin.orders.show', $order)
            ->with('success', 'Order status updated successfully.');
    }
}
