<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\OrderService;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class OrderController extends Controller
{

    public function __construct(
        protected OrderService $orderService
    ) {}

    use AuthorizesRequests;

    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = $this->orderService->getUserOrders();

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Policy, ensure the user can only view their own orders
        $this->authorize('view', $order);

        $order = $this->orderService->getUserOrderById($order);

        return view('orders.show', compact('order'));
    }
}
