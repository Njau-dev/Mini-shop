# Mini Shop – Red Giant Laravel Assessment

- A mini e-commerce system built with Laravel 11 for the Red Giant full-stack assessment.
Designed with role-based access and a complete shopping workflow from catalog to checkout.

## Table of Contents

1. Installation & Setup
2. Usage Guide
3. Tech stack

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
