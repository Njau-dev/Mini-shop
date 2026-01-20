<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{

    use AuthorizesRequests;

    /**
     * Display a listing of the user's orders.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->withCount('items')
            ->orderBy('created_at', 'desc')
            ->paginate(10);

        return view('orders.index', compact('orders'));
    }

    /**
     * Display the specified order.
     */
    public function show(Order $order)
    {
        // Policy, ensure the user can only view their own orders
        $this->authorize('view', $order);

        $order->load('items.product.category');

        return view('orders.show', compact('order'));
    }
}
