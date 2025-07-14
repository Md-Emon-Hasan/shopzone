CREATE DATABASE shopzone;
USE shopzone;

CREATE TABLE users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    original_price DECIMAL(10,2),
    image VARCHAR(255),
    category VARCHAR(50),
    description TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE orders (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    total DECIMAL(10,2) NOT NULL,
    status VARCHAR(20) DEFAULT 'Processing',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id)
);

CREATE TABLE order_items (
    id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(10,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id),
    FOREIGN KEY (product_id) REFERENCES products(id)
);

INSERT INTO products (name, price, original_price, image, category, description) VALUES
('Smartphone', 25000, 30000, 'assets/images/products/smartphone.png', 'electronics', 'Latest smartphone with advanced features'),
('Laptop', 55000, 60000, 'assets/images/products/laptop.png', 'electronics', 'High-performance laptop for work and gaming'),
('T-Shirt', 800, 1000, 'assets/images/products/tshirt.png', 'clothing', 'Comfortable cotton t-shirt'),
('Jeans', 1500, 2000, 'assets/images/products/jeans.png', 'clothing', 'Premium quality denim jeans'),
('Programming Book', 1200, 1500, 'assets/images/products/book.png', 'books', 'Comprehensive programming guide'),
('Garden Tools', 2500, 3000, 'assets/images/products/tools.png', 'home', 'Essential gardening tools set'),
('Wireless Earbuds', 3500, 4000, 'assets/images/products/earbuds.png', 'electronics', 'Premium wireless earbuds with noise cancellation'),
('Casual Shirt', 1200, 1500, 'assets/images/products/shirt.png', 'clothing', 'Stylish casual shirt for everyday wear');