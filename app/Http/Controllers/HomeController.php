<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    public function index()
    {
        // Get all categories
        $categories = Category::withCount('products')->get();

        // Get top 5 best selling products based on order count
        // Assuming you have an orders table with product_id
        // $bestSellingProducts = Product::select('products.*', DB::raw('COUNT(order_items.id) as order_count'))
        //     ->leftJoin('order_items', 'products.id', '=', 'order_items.product_id')
        //     ->with('category')
        //     ->groupBy('products.id')
        //     ->orderByDesc('order_count')
        //     ->limit(5)
        //     ->get();

        // // If no orders exist yet, get 5 random products
        // if ($bestSellingProducts->isEmpty() || $bestSellingProducts->sum('order_count') == 0) {
        //     $bestSellingProducts = Product::with('category')
        //         ->where('stock', '>', 0)
        //         ->inRandomOrder()
        //         ->limit(5)
        //         ->get();
        // }

        $bestSellingProducts = Product::with(['category'])
            ->where('stock', '>', 0)
            ->latest()
            ->take(4)
            ->get();

        return view('welcome', compact('categories', 'bestSellingProducts'));
    }
}
