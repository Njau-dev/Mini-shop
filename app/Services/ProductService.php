<?php

namespace App\Services;

use App\Models\Category;
use App\Models\Product;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        private ProductRepository $products
    ) {}

    public function list(array $filters): array
    {
        return [
            'products'       => $this->products->paginatedWithFilters($filters),
            'categories'     => Category::withCount('products')->orderBy('name')->get(),
            'totalProducts'  => Product::count(),
            'viewMode'       => $filters['view'] ?? 'grid',
        ];
    }

    public function show(Product $product): array
    {
        return [
            'product'          => $product->load('category'),
            'relatedProducts'  => $this->products->relatedProducts($product),
        ];
    }
}
