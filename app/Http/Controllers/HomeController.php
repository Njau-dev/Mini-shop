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

        // fetch best selling products based on order count
        $bestSellingProducts = Product::with('category')
            ->withCount(['orderItems as order_count' => function ($query) {
                $query->whereHas('order');
            }])
            ->orderByDesc('order_count')
            ->limit(4)
            ->get();

        return view('welcome', compact('categories', 'bestSellingProducts'));
    }
}
