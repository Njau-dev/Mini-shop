<?php

namespace App\Repositories;

use App\Models\Product;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ProductRepository
{

    public function create(array $data): Product
    {
        return Product::create($data);
    }

    public function update(Product $product, array $data): Product
    {
        $product->update($data);
        return $product;
    }

    public function delete(Product $product): bool
    {
        return $product->delete();
    }

    public function paginatedWithFilters(array $filters): LengthAwarePaginator
    {
        $query = Product::with('category');

        if (!empty($filters['search'])) {
            $query->where(function ($q) use ($filters) {
                $q->where('name', 'like', "%{$filters['search']}%")
                    ->orWhere('description', 'like', "%{$filters['search']}%");
            });
        }

        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        match ($filters['sort'] ?? 'name') {
            'price_low'  => $query->orderBy('price', 'asc'),
            'price_high' => $query->orderBy('price', 'desc'),
            'newest'     => $query->orderBy('created_at', 'desc'),
            default      => $query->orderBy('name', 'asc'),
        };

        return $query->paginate(12)->withQueryString();
    }

    public function relatedProducts(Product $product, int $limit = 4)
    {
        return Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->limit($limit)
            ->get();
    }

    public function getBestSelling(int $limit = 4)
    {
        return Product::with('category')
            ->withCount(['orderItems as order_count' => function ($query) {
                $query->whereHas('order');
            }])
            ->orderByDesc('order_count')
            ->limit($limit)
            ->get();
    }

    public function totalCount(): int
    {
        return Product::count();
    }

    public function find(int $id): ?Product
    {
        return Product::find($id);
    }

    public function totalStock(): int
    {
        return Product::sum('stock');
    }

    public function adminPaginatedProducts(): LengthAwarePaginator
    {
        return Product::with('category')->latest()->paginate(10);
    }
}
