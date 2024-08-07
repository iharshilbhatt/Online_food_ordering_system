# OOS (Online Ordering System)

## Project Description

OOS (Online Ordering System) is a web-based application designed to streamline and manage order processing, product catalogs, and user accounts for e-commerce platforms. It provides an intuitive interface for handling orders, managing product listings, and supporting user authentication with admin capabilities. This project utilizes MySQL/MariaDB for database management and PHP for server-side scripting.

## Features

- **Order Management**: Track customer orders, including details such as order ID, products, total price, and fulfillment status.
- **Product Catalog**: Maintain a detailed catalog of products with descriptions, prices, categories, and images.
- **User Management**: Handle user accounts with authentication and role-based access control (admin and regular users).

## Database Schema

### 1. Orders Table

- **Purpose**: Stores details about customer orders.
- **Columns**:
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY): Unique identifier for each order.
  - `user_id` (INT, FOREIGN KEY): References `users(id)`, linking orders to users.
  - `order_id` (VARCHAR): Unique order identifier.
  - `products` (TEXT): Comma-separated list of product IDs included in the order.
  - `total_price` (DECIMAL): Total price of the order.
  - `fulfilled` (VARCHAR): Status of order fulfillment ('0' for pending, '1' for fulfilled).

### 2. Products Table

- **Purpose**: Contains information about products in the catalog.
- **Columns**:
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY): Unique identifier for each product.
  - `product_id` (TEXT): Unique product identifier.
  - `name` (VARCHAR): Product name.
  - `description` (TEXT): Detailed product description.
  - `category` (TEXT): Product category (e.g., Pizza, Pasta, Soup).
  - `price` (DECIMAL): Price of the product.
  - `picture_url` (VARCHAR): URL to the product image.
  - `status` (TINYINT): Indicates if the product is active (1) or inactive (0).

### 3. Users Table

- **Purpose**: Manages user accounts and authentication.
- **Columns**:
  - `id` (INT, AUTO_INCREMENT, PRIMARY KEY): Unique identifier for each user.
  - `mobile` (VARCHAR): User's mobile number.
  - `password` (VARCHAR): Hashed password for secure authentication.
  - `is_admin` (TINYINT): Indicates if the user is an admin (1) or a regular user (0).

## Installation Instructions

### Prerequisites

- **MySQL/MariaDB**: Ensure you have MySQL or MariaDB installed and running.
- **PHP**: Ensure PHP is installed and configured to work with MySQL/MariaDB.
- **Web Server**: Apache or any other compatible web server.

### Steps

***Set Up the Web Server:***

- Ensure your web server (e.g., Apache) is running.
- Place the project files in the web server’s document root directory.
- Make sure the web server has read and write permissions for the project files.

***Access the Application:***

- Open a web browser and navigate to http://localhost/ to access the application.

### Usage

### Admin Panel

- **Login:** Use the admin credentials (mobile: 1234567890, password: 1234) to log in.
- **Manage Orders:** View and update the status of orders.
- **Manage Products:** Add, edit, or remove products from the catalog.
- **Manage Users:** Create, edit, or remove user accounts.

**Regular Users**
- **Login:** Use user credentials to log in.
- **View Products:** Browse the product catalog.
- **Place Orders:** Add products to the cart and place orders.

**Configuration**
- **Database:** Configure your database connection in include/conn.php.
- **Product Images:** Ensure that product image URLs are accessible and correctly formatted.


**Troubleshooting**

- **Database Connection Issues:**

- Ensure that database credentials in include/conn.php are correct.
- Verify that the MySQL/MariaDB server is running.

**Missing Files:**
- Make sure all necessary files are included and located in the correct directories.
**Permission Issues:**
- Check file and directory permissions to ensure the web server can read/write as needed.
