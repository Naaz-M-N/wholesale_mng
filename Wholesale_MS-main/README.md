# Wholesale Management System

The Wholesale Management System is a PHP-based web application designed to manage wholesale products, customers, transactions, and suppliers. This system provides functionalities for customers to browse and purchase products, while administrators can manage the product inventory and track transactions.

## Features

- User registration and login
- Secure password storage using hashing
- Product browsing and searching
- Adding products to cart
- Checkout and order placement
- Administrator dashboard for managing products, customers, and suppliers
- Low stock alerts for administrators
- Detailed transaction tracking

## Technologies Used

- PHP
- MySQL (MariaDB)
- HTML, CSS, JavaScript
- phpMyAdmin for database management

## Database Structure

The database consists of the following main tables:

- `customer`: Stores customer information
- `products`: Stores product details
- `categories`: Stores product categories
- `transaction`: Stores transaction details
- `transaction_details`: Stores details of each transaction
- `suppliers`: Stores supplier information
- `supplier_products`: Stores products provided by suppliers
- `supplier_stock`: Stores the stock details of suppliers
- `depleted_products`: Stores products with low stock
- `cart`: Stores temporary cart information for customers

## Installation

1. Clone the repository to your local machine.
2. Import the database `wholesale` from the provided SQL dump file into your MySQL server using phpMyAdmin or MySQL command line.
3. Configure your database connection in the `config.php` file:
   ```php
   <?php
   $serverName = "localhost";
   $userName = "root";
   $password = "";
   $dbName = "wholesale";
   $conn = mysqli_connect($serverName, $userName, $password, $dbName);
   ?>
