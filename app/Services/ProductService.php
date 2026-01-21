<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductRepository;

class ProductService
{
    public function __construct(
        protected ProductRepository $products,
        protected CategoryRepository $categories
    ) {}


    public function createProduct(array $data): Product
    {
        return $this->products->create($data);
    }

    public function updateProduct(Product $product, array $data): Product
    {
        return $this->products->update($product, $data);
    }

    public function list(array $filters): array
    {
        return [
            'products'       => $this->products->paginatedWithFilters($filters),
            'categories'     => $this->categories->getCategoriesWithProductCount(),
            'totalProducts'  => $this->products->totalCount(),
            'viewMode'       => $filters['view'] ?? 'grid',
        ];
    }

    public function show(int $productId): array
    {
        $product = $this->products->find($productId);
        return [
            'product'          => $product->load('category'),
            'relatedProducts'  => $this->products->relatedProducts($product),
        ];
    }

    public function getBestSellingProducts(int $limit = 4)
    {
        return $this->products->getBestSelling($limit);
    }

    public function totalCount(): int
    {
        return $this->products->totalCount();
    }

    public function totalStock(): int
    {
        return $this->products->totalStock();
    }

    public function getProduct(int $productId): ?Product
    {
        return $this->products->find($productId);
    }

    public function isAvailable(Product $product, int $quantity): bool
    {
        return $product->stock >= $quantity;
    }

    public function getAdminPaginatedProducts()
    {
        return $this->products->adminPaginatedProducts();
    }

    public function deleteProduct(Product $product)
    {
        return $this->products->delete($product);
    }
}
