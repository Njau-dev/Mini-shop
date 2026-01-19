<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;

class HomeController extends Controller
{
    public function __construct(
        protected CategoryService $categoryService,
        protected ProductService $productService
    ) {}

    /**
     * Display homepage
     */
    public function index()
    {
        // Get categories with product count
        $categories = $this->categoryService->getCategoriesWithProductCount();

        // Get best selling products
        $bestSellingProducts = $this->productService->getBestSellingProducts(4);

        return view('welcome', compact('categories', 'bestSellingProducts'));
    }
}

