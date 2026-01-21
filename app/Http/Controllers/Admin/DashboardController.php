<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Services\CategoryService;
use App\Services\ProductService;
use App\Services\UserService;

class DashboardController extends Controller
{
    /**
     * Display the admin dashboard with statistics
     */

    public function __construct(
        protected ProductService $productService,
        protected CategoryService $categoryService,
        protected UserService $userService
    ) {}

    public function index()
    {
        // Fetch statistics from services
        $stats = [
            'total_products' => $this->productService->totalCount(),
            'total_categories' => $this->categoryService->getTotalCount(),
            'total_users' => $this->userService->getUserCount(),
            'total_stock' => $this->productService->totalStock(),
        ];

        return view('admin.dashboard', compact('stats'));
    }
}
