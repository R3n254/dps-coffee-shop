# DPS Coffee Shop ☕

A web-based coffee shop application built with PHP, MySQL, and Bootstrap 5.

## Features
- Role-based authentication (Admin & Customer)
- Product management (CRUD)
- Automatic 10% customer discount
- Responsive design

## Tech Stack
- PHP
- MySQL
- HTML5
- Bootstrap 5
- JavaScript

## Project Structure
```text
coffee_shop/
├── auth.php
├── config.php
├── index.php
├── login.php
├── logout.php
├── add_product.php
├── edit_product.php
├── delete.php
└── navbar.php
```

## Setup
1. Place the project folder in `C:\xampp\htdocs\`.
2. Start Apache and MySQL in XAMPP.
3. Open phpMyAdmin and execute:

```sql
CREATE DATABASE IF NOT EXISTS coffee_shop;
USE coffee_shop;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL,
    password VARCHAR(255) NOT NULL,
    role ENUM('admin', 'customer') NOT NULL
);

INSERT INTO users (username, password, role)
VALUES ('admin', 'admin123', 'admin');

CREATE TABLE product (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price INT NOT NULL,
    image_url TEXT NOT NULL
);
```

4. Open [http://localhost/coffee_shop/login.php](http://localhost/coffee_shop/login.php).

### Default Admin Login
- **Username:** `admin`
- **Password:** `admin123`
