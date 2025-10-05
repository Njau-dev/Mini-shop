# SQL Solutions – Red Giant Laravel Assessment

- Query outputs have been captured and saved in the sql_screenshots/ folder.


## 1. Top 5 Best-Selling Products

- Shows the top 5 best-selling products based on total quantity sold.

    ```sql

    SELECT 
        products.id,
        products.name,
        SUM(order_items.quantity) AS total_sold
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    GROUP BY products.id, products.name
    ORDER BY total_sold DESC
    LIMIT 5;


### Result example

    ```
        +----+----------------+------------+
        | id | name           | total_sold |
        +----+----------------+------------+
        | 11 | Baseball Cap   |         13 |
        | 12 | Beanie         |          4 |
        | 15 | Denim Jacket   |          2 |
        | 17 | Slim Fit Jeans |          2 |
        | 16 | Winter Parka   |          1 |
        +----+----------------+------------+
    ```

## 2. Total Revenue per Product

- Calculates total revenue for each product.

    ```sql

    SELECT 
        products.id,
        products.name,
        SUM(order_items.quantity * products.price) AS total_revenue
    FROM order_items
    JOIN products ON order_items.product_id = products.id
    GROUP BY products.id, products.name
    ORDER BY total_revenue DESC;


### Result example

    ```
        +----+----------------+---------------+
        | id | name           | total_revenue |
        +----+----------------+---------------+
        | 11 | Baseball Cap   |        324.87 |
        | 15 | Denim Jacket   |        159.98 |
        | 16 | Winter Parka   |        129.99 |
        | 17 | Slim Fit Jeans |        119.98 |
        | 12 | Beanie         |         79.96 |
        +----+----------------+---------------+
    ```

## 3. Total Orders and Lifetime spend per Customer 

- Shows each customer’s total number of orders and their lifetime spend

    ```sql

    SELECT 
        users.id,
        users.name,
        COUNT(orders.id) AS total_orders,
        SUM(orders.total) AS lifetime_spend
    FROM users
    JOIN orders ON orders.user_id = users.id
    GROUP BY users.id, users.name
    ORDER BY lifetime_spend DESC;
    

### Result example

    ```
        +----+---------------+--------------+----------------+
        | id | name          | total_orders | lifetime_spend |
        +----+---------------+--------------+----------------+
        | 16 | Test Customer |            7 |         694.83 |
        | 15 | Test Admin    |            1 |          69.97 |
        | 18 | Final User    |            1 |          49.98 |
        +----+---------------+--------------+----------------+
    ```


## How to Run the SQL Queries

- Follow these steps to test or verify the SQL commands above:

### 1. Run all migrations and seeders first (if not already done during initial setup)

- This ensures that all required tables (users, products and categories) exist and contain sample data.

    ```
        php artisan migrate --seed
    ```

### 2. Create at least one order via the UI

- Log in as the seeded customer (customer@demo.com / password).

- Add 1–2 items to the cart and complete checkout.

- This ensures that your database has real order data to query.

### 3. Open the Laravel database shell

    ```
        php artisan db
    ```

    ```sql
        USE database_name;
    ```

- This command opens an interactive SQL shell and connects to your project’s current database

### 4. Copy and paste each query

### 5. Compare your results

- Expected output tables are shown above for reference.

### 6. Screenshots

- Query outputs have been captured and saved in the sql_screenshots/ folder.
