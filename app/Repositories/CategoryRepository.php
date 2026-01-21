<?php

namespace App\Repositories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

/**
 * CategoryRepository
 *
 * Handles all category database queries
 */
class CategoryRepository
{
    /**
     * Get all categories
     */
    public function all(): Collection
    {
        return Category::all();
    }

    /**
     * Get all categories with product count
     */
    public function allWithProductCount(): Collection
    {
        return Category::withCount('products')->get();
    }

    /**
     * Find category by ID
     */
    public function find(int $id): ?Category
    {
        return Category::find($id);
    }

    /**
     * Create category
     */
    public function create(array $data): Category
    {
        return Category::create($data);
    }

    /**
     * Update category
     */
    public function update(Category $category, array $data): bool
    {
        return $category->update($data);
    }

    /**
     * Delete category
     */
    public function delete(Category $category): bool
    {
        return $category->delete();
    }

    public function getCategoriesWithProductCount(): Collection
    {
        return Category::withCount('products')->orderBy('name')->get();
    }

    public function getCategoriesWithPaginatedProducts(): LengthAwarePaginator
    {
        return Category::withCount('products')->latest()->paginate(10);
    }

    public function totalCount(): int
    {
        return Category::count();
    }
}
