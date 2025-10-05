# Mini Shop – Red Giant Laravel Assessment

- A mini e-commerce system built with Laravel 11 for the Red Giant full-stack assessment.
Designed with role-based access and a complete shopping workflow from catalog to checkout.

## Table of Contents

1. Installation & Setup
2. Usage Guide
3. Tech stack
4. API Testing
5. SQL Answers

## Requirements

- **PHP**: v8.2 or higher  
- **Laravel**: v11  
- **Node.js**: v18 or higher (includes `npm`)  
- **MySQL**: v8 or compatible  
- **Git**

---

## 1. Installation & Setup

1. **Clone the repository**

- Get a copy of the project from GitHub and move into the project folder.

   ```
   git clone https://github.com/Njau-dev/Mini-shop.git
   cd Mini-shop
   ```
   
2. **Install Dependencies**

- These commands install all Laravel backend dependencies and frontend assets as well.

   ```
   composer install
   npm install
   ```
   
3. **Configure environment**

- Duplicate the example environment file and generate the application key.

    ```
    cp .env.example .env
    php artisan key:generate
    ```

4. **Create a MySQL database**

- Log in to MySQL and create a database for the project.

    ```
    mysql -u root -p
    CREATE DATABASE mini_shop;
    EXIT;
    ```

5. **Configure .env Credentials**

- Open .env and set your database connection details.

    ```
    DB_CONNECTION=mysql
    DB_HOST=127.0.0.1
    DB_PORT=3306
    DB_DATABASE=mini_shop
    DB_USERNAME=root
    DB_PASSWORD=your_password
    ```

6. **Run migrations and seeders**

- This creates all database tables and seeds default users and sample products. 

    ```
    php artisan migrate --seed
    ```

7. **Start the development server**
    ```
    php artisan serve
    ```

8. **Run Vite for Tailwind and assets**

- This compiles Tailwind CSS and watches for UI changes.
    ```
    npm run dev
    ```


The project will be available at 👉 http://localhost:8000



## 2. Usage Guide

### Guest Users

- Guests can access the Welcome (/) and Catalog (/catalog) pages.

- They can browse available products and view individual product details.

- To add products to the cart or place orders, they must create an account or log in.

### Customer Users

After logging in as a customer, you can:

    - Browse and search for products from the Catalog.

    - Add products to your Cart.

    - Update or remove items from the cart.

    - Proceed to Checkout to confirm and create an order.

    - View your Order History and detailed Order Summary.

    - Access your Profile to update account details.

#### Sample customer credentials:

 - Email: customer@demo.com  
 - Password: password


### Admin Users

After logging in as a customer, you can:

    - Accessing the Dashboard for an overview of products and activity.

    - Managing Products — create, update, and delete items.

    - Managing Categories.

    - Viewing and managing all Users in the system.

    - Managing Orders — view customer orders and order details.


#### Sample admin credentials:

 - Email: admin@demo.com  
 - Password: password


### Roles summary
    ```
        | Role     | Features Available                                |
        | -------- | ------------------------------------------------- |
        | Guest    | View welcome and catalog pages                    |
        | Customer | Full shopping experience (cart, checkout, orders) |
        | Admin    | Manage products, categories, users, and orders    |

    ```




## 3. Tech Stack & Features

- Backend: Laravel 11 (Blade, Eloquent ORM)

- Frontend: Tailwind CSS, Blade templates

- Database: MySQL

- Auth: Laravel Breeze with roles (Admin, Customer) and middlewares for RBAC

- API: REST endpoints for products and orders

- Other: Seeder data, validation and policies for access control


## 4. API Testing

- This project includes two main API endpoints that demonstrate product retrieval and order creation.

  1. GET – /api/products

        - Fetches all available products along with their related categories.
        This endpoint is public and does not require authentication.

        #### Example Request:

        - GET http://localhost:8000/api/products

        #### Sample JSON Response:

        ```
            [
                {
                    "id": 11,
                    "category_id": 15,
                    "name": "Baseball Cap",
                    "price": 24.99,
                    "stock": 43,
                    "description": "Classic baseball cap with adjustable strap.",
                    "created_at": "2025-10-04T18:26:14.000000Z",
                    "updated_at": "2025-10-05T02:02:12.000000Z",
                    "category": {
                    "id": 15,
                    "name": "hat",
                    "created_at": "2025-10-04T18:26:14.000000Z",
                    "updated_at": "2025-10-04T18:26:14.000000Z"
                    }
                },
                {
                    "id": 13,
                    "category_id": 16,
                    "name": "Cotton T-Shirt",
                    "price": 29.99,
                    "stock": 100,
                    "description": "100% cotton t-shirt, available in multiple colors.",
                    "created_at": "2025-10-04T18:26:14.000000Z",
                    "updated_at": "2025-10-04T18:26:14.000000Z",
                    "category": {
                    "id": 16,
                    "name": "shirt",
                    "created_at": "2025-10-04T18:26:14.000000Z",
                    "updated_at": "2025-10-04T18:26:14.000000Z"
                    }
                }
            ]
        ```


    2. POST – /api/orders

    - Creates a new order for the authenticated customer.

    - Since the app uses session-based Laravel Breeze authentication, the API cannot be tested directly via Postman.

    - Instead, use Laravel Tinker to simulate the request and view the JSON response.

    #### Steps:
    
    1. Start tinker
        ```
        php artisan tinker
        ```

    2. Run these commands inside Tinker:

        ```
            $user = App\Models\User::where('role', 'customer')->first();
            Auth::login($user);
            
            $products = App\Models\Product::limit(2)->get();

            echo "Available Products:\n";
            foreach ($products as $product) {
                echo "ID: {$product->id}, Name: {$product->name}, Price: {$product->price}, Stock: {$product->stock}\n";
            }

            $orderData = [
                'items' => [
                    ['product_id' => $products[0]->id, 'quantity' => 2],
                    ['product_id' => $products[1]->id, 'quantity' => 1],
                ],
                'shipping_phone' => '+254712345678'
            ];

            $request = new Illuminate\Http\Request($orderData);
            $controller = new App\Http\Controllers\Api\OrderApiController();
            $response = $controller->store($request);

            echo "\n=== API RESPONSE ===\n";
            echo "Status Code: " . $response->getStatusCode() . "\n";
            echo "Response Content: "  .  $response->getContent() . "\n";
        ```

    ### Expected Output:

        ```
            === API RESPONSE ===
            Status Code: 201
            Response Content: {"message":"Order created","order_id":13,"total":69.97}
        ```

## 5. SQL Answers

- SQL solutions and screenshots are located in the sql_answers/ folder.

- Please refer to the README.md inside that folder for:

    - Step-by-step guide on how to run SQL commands using php artisan db.

    - Screenshot results for all 3 queries (query_1.png, query_2.png, query_3.png).
