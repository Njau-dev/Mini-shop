<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\CartRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;

/**
 * CartService - HYBRID IMPLEMENTATION
 *
 * - Session cart for guests
 * - Database cart for authenticated users
 * - Auto-merges session cart to DB on login
 */
class CartService
{
    protected string $sessionKey = 'cart';

    public function __construct(
        protected CartRepository $cartRepository,
        protected ProductService $productService
    ) {}

    /**
     * Add item to cart (works for both guest and user)
     */
    public function addItem(int $productId, int $quantity = 1): array
    {
        $product = $this->productService->getProduct($productId);

        if (!$product) {
            throw new \Exception("Product not found");
        }

        // Check stock availability
        if (!$this->productService->isAvailable($product, $quantity)) {
            throw new \Exception("Requested quantity exceeds available stock. Available: {$product->stock}");
        }

        if (Auth::check()) {
            return $this->addToDatabase($product, $quantity);
        }

        return $this->addToSession($product, $quantity);
    }

    /**
     * Get all cart items
     */
    public function getItems(): array
    {
        if (Auth::check()) {
            return $this->getDatabaseItems();
        }

        return $this->getSessionItems();
    }

    /**
     * Update item quantity
     */
    public function updateQuantity(int $productId, int $quantity): array
    {
        if ($quantity < 1) {
            throw new \Exception("Quantity must be at least 1");
        }

        $product = $this->productService->getProduct($productId);

        if (!$product) {
            throw new \Exception("Product not found");
        }

        if (!$this->productService->isAvailable($product, $quantity)) {
            throw new \Exception("Requested quantity exceeds available stock. Available: {$product->stock}");
        }

        if (Auth::check()) {
            return $this->updateDatabaseItem($productId, $quantity, $product);
        }

        return $this->updateSessionItem($productId, $quantity, $product);
    }

    /**
     * Remove item from cart
     */
    public function removeItem(int $productId): bool
    {
        if (Auth::check()) {
            return $this->removeFromDatabase($productId);
        }

        return $this->removeFromSession($productId);
    }

    /**
     * Clear entire cart
     */
    public function clear(): void
    {
        if (Auth::check()) {
            $this->cartRepository->clearUserCart(Auth::id());
        } else {
            Session::forget($this->sessionKey);
        }
    }

    /**
     * Get cart totals
     */
    public function getTotals(): array
    {
        $items = $this->getItems();
        $subtotal = 0;

        foreach ($items as $item) {
            $subtotal += $item['price'] * $item['quantity'];
        }

        $total = $subtotal; // Add tax, shipping, discounts as needed

        return [
            'total' => $total,
        ];
    }

    /**
     * Get cart item count
     */
    public function getItemCount(): int
    {
        if (Auth::check()) {
            return $this->cartRepository->getCartCount(Auth::id());
        }

        $cart = Session::get($this->sessionKey, []);
        return array_sum(array_column($cart, 'quantity'));
    }

    /**
     * Check if cart is empty
     */
    public function isEmpty(): bool
    {
        return $this->getItemCount() === 0;
    }

    /**
     * Merge session cart to database on login
     * Call this after user logs in
     */
    public function mergeSessionToDatabase(int $userId): void
    {
        $sessionCart = Session::get($this->sessionKey, []);

        if (empty($sessionCart)) {
            return;
        }

        foreach ($sessionCart as $productId => $item) {
            $existingItem = $this->cartRepository->findItem($userId, $productId);

            if ($existingItem) {
                // Update quantity if item already exists
                $newQuantity = $existingItem->quantity + $item['quantity'];
                $product = $this->productService->getProduct($productId);

                // Check stock before merging
                if ($product && $this->productService->isAvailable($product, $newQuantity)) {
                    $this->cartRepository->update($existingItem, [
                        'quantity' => $newQuantity
                    ]);
                }
            } else {
                // Add new item to database
                $this->cartRepository->create($userId,
                [
                    'product_id' => $productId,
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                ]);
            }
        }

        // Clear session cart after merge
        Session::forget($this->sessionKey);
    }

    // ============================================================
    // PRIVATE METHODS - Session Cart
    // ============================================================

    private function addToSession(Product $product, int $quantity): array
    {
        $cart = Session::get($this->sessionKey, []);

        if (isset($cart[$product->id])) {
            $newQuantity = $cart[$product->id]['quantity'] + $quantity;

            if (!$this->productService->isAvailable($product, $newQuantity)) {
                throw new \Exception("Cannot add more items. Stock limit reached.");
            }

            $cart[$product->id]['quantity'] = $newQuantity;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => $quantity,
                'category' => $product->category->name,
                'stock' => $product->stock,
                'image' => $product->image_path,
            ];
        }

        Session::put($this->sessionKey, $cart);

        return $cart[$product->id];
    }

    private function getSessionItems(): array
    {
        return Session::get($this->sessionKey, []);
    }

    private function updateSessionItem(int $productId, int $quantity, Product $product): array
    {
        $cart = Session::get($this->sessionKey, []);

        if (!isset($cart[$productId])) {
            throw new \Exception("Item not found in cart");
        }

        $cart[$productId]['quantity'] = $quantity;
        Session::put($this->sessionKey, $cart);

        return $cart[$productId];
    }

    private function removeFromSession(int $productId): bool
    {
        $cart = Session::get($this->sessionKey, []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            Session::put($this->sessionKey, $cart);
            return true;
        }

        return false;
    }

    // ============================================================
    // PRIVATE METHODS - Database Cart
    // ============================================================

    private function addToDatabase(Product $product, int $quantity): array
    {
        $existingItem = $this->cartRepository->findItem(Auth::id(), $product->id);

        if ($existingItem) {
            $newQuantity = $existingItem->quantity + $quantity;

            if (!$this->productService->isAvailable($product, $newQuantity)) {
                throw new \Exception("Cannot add more items. Stock limit reached.");
            }

            $this->cartRepository->update($existingItem, [
                'quantity' => $newQuantity
            ]);

            $cartItem = $existingItem->fresh();
        } else {
            $cartItem = $this->cartRepository->create(
                Auth::id(),
                [
                    'product_id' => $product->id,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ]
            );

            $cartItem->load('product.category');
        }

        return [
            'product_id' => $cartItem->product_id,
            'name' => $cartItem->product->name,
            'price' => $cartItem->price,
            'quantity' => $cartItem->quantity,
            'category' => $cartItem->product->category->name,
            'stock' => $cartItem->product->stock,
            'image' => $cartItem->product->image_path,
        ];
    }

    private function getDatabaseItems(): array
    {
        $cartItems = $this->cartRepository->getUserCart(Auth::id());
        $items = [];

        foreach ($cartItems as $item) {
            $items[$item->product_id] = [
                'product_id' => $item->product_id,
                'name' => $item->product->name,
                'price' => $item->price,
                'quantity' => $item->quantity,
                'category' => $item->product->category->name,
                'stock' => $item->product->stock,
                'image' => $item->product->image_path,
            ];
        }

        return $items;
    }

    private function updateDatabaseItem(int $productId, int $quantity, Product $product): array
    {
        $cartItem = $this->cartRepository->findItem(Auth::id(), $productId);

        if (!$cartItem) {
            throw new \Exception("Item not found in cart");
        }

        $this->cartRepository->update($cartItem, ['quantity' => $quantity]);

        return [
            'product_id' => $productId,
            'name' => $product->name,
            'price' => $cartItem->price,
            'quantity' => $quantity,
            'category' => $product->category->name,
            'stock' => $product->stock,
            'image' => $product->image_path,
        ];
    }

    private function removeFromDatabase(int $productId): bool
    {
        $cartItem = $this->cartRepository->findItem(Auth::id(), $productId);

        if ($cartItem) {
            return $this->cartRepository->delete($cartItem);
        }

        return false;
    }
}
