<?php

namespace App\Repositories;

use App\Models\Cart;
use App\Models\CartItem;
use Illuminate\Database\Eloquent\Collection;

/**
 * CartRepository
 *
 * Handles database operations for authenticated user carts
 */
class CartRepository
{
    /**
     * Get or create user's cart
     */
    protected function getCart(int $userId): Cart
    {
        return Cart::firstOrCreate(['user_id' => $userId]);
    }

    /**
     * Get all cart items for a user
     */
    public function getUserCart(int $userId): Collection
    {
        return $this->getCart($userId)
            ->items()
            ->with('product.category')
            ->get();
    }

    /**
     * Find specific cart item
     */
    public function findItem(int $userId, int $productId): ?CartItem
    {
        $cart = $this->getCart($userId);

        return $cart->items()
            ->where('product_id', $productId)
            ->first();
    }

    /**
     * Create cart item
     */
    /**
     * Create cart item
     */
    public function create(int $userId, array $data): CartItem
    {
        $cart = $this->getCart($userId);

        return $cart->items()->create($data);
    }

    /**
     * Update cart item
     */
    public function update(CartItem $item, array $data): bool
    {
        return $item->update($data);
    }

    /**
     * Delete cart item
     */
    public function delete(CartItem $item): bool
    {
        return $item->delete();
    }

    /**
     * Clear all cart items for a user
     */
    public function clearUserCart(int $userId): int
    {
        return $this->getCart($userId)
            ->items()
            ->delete();
    }

    /**
     * Get cart count for user
     */
    public function getCartCount(int $userId): int
    {
        return $this->getCart($userId)
            ->items()
            ->sum('quantity');
    }
}
