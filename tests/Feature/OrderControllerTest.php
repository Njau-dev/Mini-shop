<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Product;
use App\Models\Category;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class OrderControllerTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $category;

    protected function setUp(): void
    {
        parent::setUp();
        $this->user = User::factory()->create();
        $this->category = Category::factory()->create();
        $this->actingAs($this->user);
    }

    /** @test */
    public function it_creates_an_order_successfully_with_valid_data()
    {
        // Arrange
        $product1 = Product::factory()->create([
            'price' => 100,
            'stock' => 10,
            'category_id' => $this->category->id
        ]);
        $product2 = Product::factory()->create([
            'price' => 200,
            'stock' => 5,
            'category_id' => $this->category->id
        ]);

        $orderData = [
            'items' => [
                ['product_id' => $product1->id, 'quantity' => 2],
                ['product_id' => $product2->id, 'quantity' => 1],
            ]
        ];

        // Act
        $response = $this->postJson('/api/orders', $orderData);

        // Display API response
        echo "\n=== API Response for Valid Order ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(200)
            ->assertJson([
                'message' => 'Order created',
            ])
            ->assertJsonStructure(['message', 'order_id']);

        // Check database
        $this->assertDatabaseHas('orders', [
            'user_id' => $this->user->id,
            'total' => 400, // (2 * 100) + (1 * 200)
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product1->id,
            'quantity' => 2,
            'price' => 100,
        ]);

        $this->assertDatabaseHas('order_items', [
            'product_id' => $product2->id,
            'quantity' => 1,
            'price' => 200,
        ]);
    }

    /** @test */
    public function it_validates_required_fields()
    {
        // Act
        $response = $this->postJson('/api/orders', []);

        // Display API response
        echo "\n=== API Response for Missing Items ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items']);
    }

    /** @test */
    public function it_validates_items_must_be_an_array()
    {
        // Act
        $response = $this->postJson('/api/orders', [
            'items' => 'not-an-array'
        ]);

        // Display API response
        echo "\n=== API Response for Non-Array Items ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items']);
    }

    /** @test */
    public function it_validates_items_array_cannot_be_empty()
    {
        // Act
        $response = $this->postJson('/api/orders', [
            'items' => []
        ]);

        // Display API response
        echo "\n=== API Response for Empty Items Array ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items']);
    }

    /** @test */
    public function it_validates_product_id_is_required_for_each_item()
    {
        // Act
        $response = $this->postJson('/api/orders', [
            'items' => [
                ['quantity' => 1]
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Missing Product ID ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.product_id']);
    }

    /** @test */
    public function it_validates_quantity_is_required_for_each_item()
    {
        // Act
        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => 1]
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Missing Quantity ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.quantity']);
    }

    /** @test */
    public function it_validates_product_exists()
    {
        // Act
        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => 999, 'quantity' => 1]
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Non-Existent Product ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.product_id']);
    }

    /** @test */
    public function it_validates_quantity_must_be_at_least_1()
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        // Act
        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 0]
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Quantity Less Than 1 ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.quantity']);
    }

    /** @test */
    public function it_fails_when_quantity_exceeds_stock()
    {
        // Arrange
        $product = Product::factory()->create([
            'stock' => 5,
            'category_id' => $this->category->id
        ]);

        // Act
        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 10],
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Insufficient Stock ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(400)
            ->assertJson(['error' => "Insufficient stock for {$product->name}"]);

        $this->assertDatabaseCount('orders', 0);
        $this->assertDatabaseCount('order_items', 0);
    }

    /** @test */
    public function it_calculates_total_correctly_for_multiple_items()
    {
        // Arrange
        $product1 = Product::factory()->create([
            'price' => 150,
            'stock' => 10,
            'category_id' => $this->category->id
        ]);
        $product2 = Product::factory()->create([
            'price' => 75,
            'stock' => 10,
            'category_id' => $this->category->id
        ]);

        $orderData = [
            'items' => [
                ['product_id' => $product1->id, 'quantity' => 3], // 450
                ['product_id' => $product2->id, 'quantity' => 2], // 150
            ]
        ];

        // Act
        $response = $this->postJson('/api/orders', $orderData);

        // Display API response
        echo "\n=== API Response for Total Calculation ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Assert
        $response->assertStatus(200);

        $this->assertDatabaseHas('orders', [
            'total' => 600, // 450 + 150
        ]);
    }

    /** @test */
    public function it_stores_price_at_time_of_order_creation()
    {
        // Arrange
        $product = Product::factory()->create([
            'price' => 100,
            'stock' => 10,
            'category_id' => $this->category->id
        ]);

        $orderData = [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 2],
            ]
        ];

        // Act
        $response = $this->postJson('/api/orders', $orderData);

        // Display API response
        echo "\n=== API Response for Price Storage ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        // Change product price (should not affect existing order)
        $product->update(['price' => 150]);

        // Assert
        $this->assertDatabaseHas('order_items', [
            'product_id' => $product->id,
            'price' => 100, // Original price, not the updated one
        ]);
    }

    /** @test */
    public function it_handles_single_item_order()
    {
        $product = Product::factory()->create([
            'price' => 50,
            'stock' => 1,
            'category_id' => $this->category->id
        ]);

        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1]
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Single Item Order ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        $response->assertStatus(200);
        $this->assertDatabaseCount('orders', 1);
        $this->assertDatabaseCount('order_items', 1);
    }

    /** @test */
    public function it_requires_authentication()
    {
        // Logout user
        auth()->logout();

        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 1]
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Unauthenticated Request ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        $response->assertUnauthorized();
    }

    /** @test */
    public function it_validates_quantity_must_be_integer()
    {
        $product = Product::factory()->create(['category_id' => $this->category->id]);

        $response = $this->postJson('/api/orders', [
            'items' => [
                ['product_id' => $product->id, 'quantity' => 'not-a-number']
            ]
        ]);

        // Display API response
        echo "\n=== API Response for Non-Integer Quantity ===\n";
        echo "Status: " . $response->getStatusCode() . "\n";
        echo "Response: " . $response->getContent() . "\n";

        $response->assertStatus(422)
            ->assertJsonValidationErrors(['items.0.quantity']);
    }
}
