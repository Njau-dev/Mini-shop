<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

/**
 * CategoryService
 *
 * Handles category business logic
 */
class CategoryService
{
    public function __construct(
        protected CategoryRepository $categoryRepository
    ) {}

    /**
     * Get all categories
     */
    public function getAllCategories()
    {
        return $this->categoryRepository->all();
    }

    /**
     * Get categories with product count
     */
    public function getCategoriesWithProductCount()
    {
        return $this->categoryRepository->allWithProductCount();
    }

    /**
     * Get categories with products
     */
    public function getCategoriesWithProducts()
    {
        return $this->categoryRepository->getCategoriesWithPaginatedProducts();
    }

    /**
     * Get total category count
     */
    public function getTotalCount(): int
    {
        return $this->categoryRepository->totalCount();
    }

    /**
     * Get single category
     */
    public function getCategory(int $id)
    {
        return $this->categoryRepository->find($id);
    }

    /**
     * Create category
     */
    public function createCategory(array $data)
    {
        return $this->categoryRepository->create($data);
    }

    /**
     * Update category
     */
    public function updateCategory(int $id, array $data)
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            throw new \Exception("Category not found");
        }

        $this->categoryRepository->update($category, $data);

        return $category->fresh();
    }

    /**
     * Delete category
     */
    public function deleteCategory(int $id): bool
    {
        $category = $this->categoryRepository->find($id);

        if (!$category) {
            throw new \Exception("Category not found");
        }

        return $this->categoryRepository->delete($category);
    }
}
