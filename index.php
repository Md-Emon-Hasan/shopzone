<?php
require_once 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ShopZone - Professional E-commerce</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        /* (Keep all your existing CSS styles) */
        :root {
            --primary-color: #007bff;
            --secondary-color: #6c757d;
            --success-color: #28a745;
            --danger-color: #dc3545;
            --warning-color: #ffc107;
            --info-color: #17a2b8;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
        }

        .navbar-brand {
            font-weight: bold;
            font-size: 1.5rem;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0;
            text-align: center;
        }

        .card {
            border: none;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            transition: transform 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .product-card {
            margin-bottom: 30px;
        }

        .product-image {
            height: 200px;
            object-fit: cover;
            width: 100%;
        }

        .price {
            font-size: 1.2rem;
            font-weight: bold;
            color: var(--success-color);
        }

        .original-price {
            text-decoration: line-through;
            color: #999;
            font-size: 0.9rem;
        }

        .cart-badge {
            position: absolute;
            top: -8px;
            right: -8px;
            background: var(--danger-color);
            color: white;
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.8rem;
        }

        .sidebar {
            background: var(--light-color);
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }

        .filter-section {
            margin-bottom: 20px;
        }

        .filter-section h6 {
            margin-bottom: 10px;
            font-weight: bold;
        }

        .btn-outline-primary:hover {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }

        .footer {
            background: var(--dark-color);
            color: white;
            padding: 40px 0;
            margin-top: 50px;
        }

        .page-section {
            display: none;
        }

        .page-section.active {
            display: block;
        }

        .modal-header {
            background: var(--primary-color);
            color: white;
        }

        .range-slider {
            width: 100%;
            margin: 10px 0;
        }

        .cart-item {
            border-bottom: 1px solid #eee;
            padding: 15px 0;
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 10px;
        }

        .quantity-btn {
            width: 30px;
            height: 30px;
            border: 1px solid #ddd;
            background: white;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .quantity-input {
            width: 50px;
            text-align: center;
            border: 1px solid #ddd;
            padding: 5px;
        }

        .category-filter {
            margin-bottom: 10px;
        }

        .category-filter input[type="checkbox"] {
            margin-right: 8px;
        }

        .search-bar {
            margin-bottom: 20px;
        }

        .user-menu {
            position: relative;
        }

        .user-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: white;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            min-width: 200px;
            z-index: 1000;
            display: none;
        }

        .user-dropdown.show {
            display: block;
        }

        .user-dropdown a {
            display: block;
            padding: 10px 15px;
            text-decoration: none;
            color: #333;
            border-bottom: 1px solid #eee;
        }

        .user-dropdown a:hover {
            background: var(--light-color);
        }

        .alert {
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-primary sticky-top">
        <div class="container">
            <a class="navbar-brand" href="#" onclick="showSection('home')">
                <i class="fas fa-store"></i> ShopZone
            </a>
            
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav me-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('home')">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('products')">Products</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('about')">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#" onclick="showSection('contact')">Contact</a>
                    </li>
                </ul>
                
                <ul class="navbar-nav">
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="#" onclick="showSection('cart')">
                            <i class="fas fa-shopping-cart"></i> Cart
                            <span class="cart-badge" id="cart-count">0</span>
                        </a>
                    </li>
                    <li class="nav-item user-menu">
                        <a class="nav-link" href="#" id="user-menu-toggle">
                            <i class="fas fa-user"></i> <span id="user-name">Account</span>
                        </a>
                        <div class="user-dropdown" id="user-dropdown">
                            <div id="logged-out-menu">
                                <a href="#" onclick="showLoginModal()">Login</a>
                                <a href="#" onclick="showRegisterModal()">Register</a>
                            </div>
                            <div id="logged-in-menu" style="display: none;">
                                <a href="#" onclick="showSection('profile')">Profile</a>
                                <a href="#" onclick="showSection('orders')">Orders</a>
                                <a href="#" onclick="logout()">Logout</a>
                            </div>
                        </div>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
    <!-- Navigation (Keep your existing navigation HTML) -->
    
    <!-- Alert Container -->
    <div id="alert-container"></div>
    
    <!-- Home Section -->
    <div id="home" class="page-section active">
        <div class="hero-section">
            <div class="container">
                <h1 class="display-4">Welcome to ShopZone</h1>
                <p class="lead">Discover amazing products at unbeatable prices</p>
                <a href="#" class="btn btn-light btn-lg" onclick="showSection('products')">Shop Now</a>
            </div>
        </div>

        <div class="container my-5">
            <div class="row">
                <div class="col-md-12">
                    <h2 class="text-center mb-4">Featured Products</h2>
                    <div class="row" id="featured-products">
                        <!-- Featured products will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div id="products" class="page-section">
        <div class="container my-5">
            <h2 class="mb-4">Our Products</h2>
            
            <div class="row">
                <div class="col-md-3">
                    <div class="sidebar">
                        <h5>Filters</h5>
                        
                        <!-- Search -->
                        <div class="search-bar">
                            <input type="text" class="form-control" placeholder="Search products..." id="search-input">
                        </div>
                        
                        <!-- Price Range -->
                        <div class="filter-section">
                            <h6>Price Range</h6>
                            <div class="mb-2">
                                <input type="range" class="form-range" min="0" max="100000" value="1000" id="price-range">
                                <div class="d-flex justify-content-between">
                                    <span>৳0</span>
                                    <span id="price-display">৳100000</span>
                                </div>
                            </div>
                        </div>
                        
                        <!-- Categories -->
                        <div class="filter-section">
                            <h6>Categories</h6>
                            <div class="category-filter">
                                <input type="checkbox" id="cat-electronics" value="electronics">
                                <label for="cat-electronics">Electronics</label>
                            </div>
                            <div class="category-filter">
                                <input type="checkbox" id="cat-clothing" value="clothing">
                                <label for="cat-clothing">Clothing</label>
                            </div>
                            <div class="category-filter">
                                <input type="checkbox" id="cat-books" value="books">
                                <label for="cat-books">Books</label>
                            </div>
                            <div class="category-filter">
                                <input type="checkbox" id="cat-home" value="home">
                                <label for="cat-home">Home & Garden</label>
                            </div>
                        </div>
                        
                        <!-- Sort By -->
                        <div class="filter-section">
                            <h6>Sort By</h6>
                            <select class="form-select" id="sort-select">
                                <option value="">Default</option>
                                <option value="price-low">Price: Low to High</option>
                                <option value="price-high">Price: High to Low</option>
                                <option value="name">Name A-Z</option>
                            </select>
                        </div>
                        
                        <button class="btn btn-primary w-100" onclick="applyFilters()">Apply Filters</button>
                        <button class="btn btn-outline-secondary w-100 mt-2" onclick="clearFilters()">Clear Filters</button>
                    </div>
                </div>
                
                <div class="col-md-9">
                    <div class="row" id="products-grid">
                        <!-- Products will be loaded here -->
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Cart Section -->
    <div id="cart" class="page-section">
        <div class="container my-5">
            <h2 class="mb-4">Shopping Cart</h2>
            <div class="row">
                <div class="col-md-8">
                    <div id="cart-items">
                        <!-- Cart items will be loaded here -->
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Order Summary</h5>
                            <div class="d-flex justify-content-between">
                                <span>Subtotal:</span>
                                <span id="cart-subtotal">৳0</span>
                            </div>
                            <div class="d-flex justify-content-between">
                                <span>Shipping:</span>
                                <span>৳50</span>
                            </div>
                            <hr>
                            <div class="d-flex justify-content-between">
                                <strong>Total:</strong>
                                <strong id="cart-total">৳50</strong>
                            </div>
                            <button class="btn btn-primary w-100 mt-3" onclick="checkout()">Proceed to Checkout</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Profile Section -->
    <div id="profile" class="page-section">
        <div class="container my-5">
            <h2 class="mb-4">My Profile</h2>
            <div class="row">
                <div class="col-md-6">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Profile Information</h5>
                            <form id="profile-form">
                                <div class="mb-3">
                                    <label for="profile-name" class="form-label">Full Name</label>
                                    <input type="text" class="form-control" id="profile-name">
                                </div>
                                <div class="mb-3">
                                    <label for="profile-email" class="form-label">Email</label>
                                    <input type="email" class="form-control" id="profile-email">
                                </div>
                                <div class="mb-3">
                                    <label for="profile-phone" class="form-label">Phone</label>
                                    <input type="tel" class="form-control" id="profile-phone">
                                </div>
                                <div class="mb-3">
                                    <label for="profile-address" class="form-label">Address</label>
                                    <textarea class="form-control" id="profile-address" rows="3"></textarea>
                                </div>
                                <button type="submit" class="btn btn-primary">Update Profile</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Orders Section -->
    <div id="orders" class="page-section">
        <div class="container my-5">
            <h2 class="mb-4">Order History</h2>
            <div id="orders-list">
                <!-- Order history will be loaded here -->
            </div>
        </div>
    </div>

    <!-- About Section -->
    <div id="about" class="page-section">
        <div class="container my-5">
            <h2 class="mb-4">About ShopZone</h2>
            <p>Welcome to ShopZone, your premier destination for quality products at affordable prices. We are committed to providing an exceptional shopping experience with a wide range of products, competitive prices, and excellent customer service.</p>
            <p>Our mission is to make online shopping easy, secure, and enjoyable for everyone. With our advanced filtering system, you can easily find exactly what you're looking for.</p>
        </div>
    </div>

    <!-- Contact Section -->
    <div id="contact" class="page-section">
        <div class="container my-5">
            <h2 class="mb-4">Contact Us</h2>
            <div class="row">
                <div class="col-md-6">
                    <form id="contact-form">
                        <div class="mb-3">
                            <label for="contact-name" class="form-label">Name</label>
                            <input type="text" class="form-control" id="contact-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="contact-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="contact-message" class="form-label">Message</label>
                            <textarea class="form-control" id="contact-message" rows="5" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Send Message</button>
                    </form>
                </div>
                <div class="col-md-6">
                    <h5>Get in Touch</h5>
                    <p><i class="fas fa-map-marker-alt"></i> Dhaka, Bangladesh</p>
                    <p><i class="fas fa-phone"></i> +88 01234567890</p>
                    <p><i class="fas fa-envelope"></i> info@shopzone.com</p>
                </div>
            </div>
        </div>
    </div>
    <!-- All your page sections (Keep your existing HTML structure) -->
    
    <!-- Your modals (Keep your existing modal HTML) -->
    <!-- Login Modal -->
    <div class="modal fade" id="loginModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Login</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="login-form">
                        <div class="mb-3">
                            <label for="login-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="login-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="login-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="login-password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Login</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Register Modal -->
    <div class="modal fade" id="registerModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Register</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <form id="register-form">
                        <div class="mb-3">
                            <label for="register-name" class="form-label">Full Name</label>
                            <input type="text" class="form-control" id="register-name" required>
                        </div>
                        <div class="mb-3">
                            <label for="register-email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="register-email" required>
                        </div>
                        <div class="mb-3">
                            <label for="register-password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="register-password" required>
                        </div>
                        <div class="mb-3">
                            <label for="register-confirm-password" class="form-label">Confirm Password</label>
                            <input type="password" class="form-control" id="register-confirm-password" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Register</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer (Keep your existing footer HTML) -->

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4">
                    <h5>ShopZone</h5>
                    <p>Your trusted online shopping destination with quality products and excellent service.</p>
                </div>
                <div class="col-md-4">
                    <h5>Quick Links</h5>
                    <ul class="list-unstyled">
                        <li><a href="#" class="text-light">Privacy Policy</a></li>
                        <li><a href="#" class="text-light">Terms of Service</a></li>
                        <li><a href="#" class="text-light">Return Policy</a></li>
                        <li><a href="#" class="text-light">FAQ</a></li>
                    </ul>
                </div>
                <div class="col-md-4">
                    <h5>Follow Us</h5>
                    <div class="social-links">
                        <a href="#" class="text-light me-3"><i class="fab fa-facebook"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-twitter"></i></a>
                        <a href="#" class="text-light me-3"><i class="fab fa-instagram"></i></a>
                        <a href="#" class="text-light"><i class="fab fa-linkedin"></i></a>
                    </div>
                </div>
            </div>
            <hr class="text-light">
            <div class="text-center">
                <p>&copy; 2025 ShopZone. All rights reserved.</p>
            </div>
        </div>
    </footer>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
    <script>
        let cart = [];
        let products = [];
        let filteredProducts = [];
        let currentUser = null;

        // Initialize the website
        document.addEventListener('DOMContentLoaded', function() {
            checkUserSession();
            loadFeaturedProducts();
            loadProducts();
            setupEventListeners();
        });

        function setupEventListeners() {
            // Price range slider
            document.getElementById('price-range').addEventListener('input', function() {
                document.getElementById('price-display').textContent = '৳' + this.value;
            });

            // Search input
            document.getElementById('search-input').addEventListener('input', debounce(applyFilters, 300));

            // User menu toggle
            document.getElementById('user-menu-toggle').addEventListener('click', function(e) {
                e.preventDefault();
                e.stopPropagation();
                document.getElementById('user-dropdown').classList.toggle('show');
            });

            // Close dropdown when clicking outside
            document.addEventListener('click', function() {
                document.getElementById('user-dropdown').classList.remove('show');
            });

            // Form submissions
            document.getElementById('login-form').addEventListener('submit', handleLogin);
            document.getElementById('register-form').addEventListener('submit', handleRegister);
            document.getElementById('contact-form').addEventListener('submit', handleContact);
            document.getElementById('profile-form').addEventListener('submit', handleProfileUpdate);
        }

        function debounce(func, timeout = 300) {
            let timer;
            return (...args) => {
                clearTimeout(timer);
                timer = setTimeout(() => { func.apply(this, args); }, timeout);
            };
        }

        function showSection(sectionId) {
            // Hide all sections
            const sections = document.querySelectorAll('.page-section');
            sections.forEach(section => {
                section.classList.remove('active');
            });

            // Show selected section
            document.getElementById(sectionId).classList.add('active');

            // Load data if needed
            if (sectionId === 'cart') {
                loadCart();
            } else if (sectionId === 'orders') {
                loadOrders();
            } else if (sectionId === 'profile' && currentUser) {
                loadProfile();
            }

            // Close mobile menu if open
            const navbarCollapse = document.querySelector('.navbar-collapse');
            if (navbarCollapse.classList.contains('show')) {
                navbarCollapse.classList.remove('show');
            }
        }

        function loadProducts() {
            fetch('products.php?get_products=1')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        products = data.products;
                        filteredProducts = [...products];
                        renderProducts();
                    } else {
                        showAlert('Failed to load products', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Error loading products', 'danger');
                });
        }

        function loadFeaturedProducts() {
            fetch('products.php?get_featured=1')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const featuredGrid = document.getElementById('featured-products');
                        featuredGrid.innerHTML = '';
                        
                        data.products.forEach(product => {
                            const productCard = createProductCard(product);
                            featuredGrid.appendChild(productCard);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function renderProducts() {
            const productsGrid = document.getElementById('products-grid');
            productsGrid.innerHTML = '';

            filteredProducts.forEach(product => {
                const productCard = createProductCard(product);
                productsGrid.appendChild(productCard);
            });
        }

        function createProductCard(product) {
            const col = document.createElement('div');
            col.className = 'col-md-6 col-lg-4 product-card';
            
            col.innerHTML = `
                <div class="card h-100">
                    <img src="${product.image}" class="card-img-top product-image" alt="${product.name}">
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">${product.name}</h5>
                        <p class="card-text">${product.description}</p>
                        <div class="mt-auto">
                            <div class="price">৳${product.price}</div>
                            ${product.original_price > product.price ? 
                                `<div class="original-price">৳${product.original_price}</div>` : ''}
                            <button class="btn btn-primary w-100 mt-2" onclick="addToCart(${product.id})">
                                <i class="fas fa-shopping-cart"></i> Add to Cart
                            </button>
                        </div>
                    </div>
                </div>
            `;
            
            return col;
        }

        function addToCart(productId) {
            const product = products.find(p => p.id === productId);
            if (!product) return;

            const existingItem = cart.find(item => item.id === productId);
            if (existingItem) {
                existingItem.quantity += 1;
            } else {
                cart.push({
                    ...product,
                    quantity: 1
                });
            }

            updateCartCount();
            showAlert('Product added to cart!', 'success');
        }

        function updateCartCount() {
            const totalItems = cart.reduce((sum, item) => sum + item.quantity, 0);
            document.getElementById('cart-count').textContent = totalItems;
        }

        function loadCart() {
            const cartItems = document.getElementById('cart-items');
            cartItems.innerHTML = '';

            if (cart.length === 0) {
                cartItems.innerHTML = '<p>Your cart is empty.</p>';
                updateCartTotals();
                return;
            }

            cart.forEach(item => {
                const cartItem = document.createElement('div');
                cartItem.className = 'cart-item';
                cartItem.innerHTML = `
                    <div class="row align-items-center">
                        <div class="col-md-2">
                            <img src="${item.image}" class="img-fluid" alt="${item.name}">
                        </div>
                        <div class="col-md-4">
                            <h6>${item.name}</h6>
                            <p class="text-muted">${item.description}</p>
                        </div>
                        <div class="col-md-2">
                            <div class="price">৳${item.price}</div>
                        </div>
                        <div class="col-md-2">
                            <div class="quantity-controls">
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, -1)">-</button>
                                <input type="number" class="quantity-input" value="${item.quantity}" min="1" onchange="setQuantity(${item.id}, this.value)">
                                <button class="quantity-btn" onclick="updateQuantity(${item.id}, 1)">+</button>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="price">৳${item.price * item.quantity}</div>
                            <button class="btn btn-sm btn-danger mt-1" onclick="removeFromCart(${item.id})">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                    </div>
                `;
                cartItems.appendChild(cartItem);
            });

            updateCartTotals();
        }

        function updateQuantity(productId, change) {
            const item = cart.find(item => item.id === productId);
            if (!item) return;

            item.quantity += change;
            if (item.quantity <= 0) {
                removeFromCart(productId);
            } else {
                loadCart();
                updateCartCount();
            }
        }

        function setQuantity(productId, quantity) {
            const item = cart.find(item => item.id === productId);
            if (!item) return;

            const newQuantity = parseInt(quantity);
            if (newQuantity <= 0) {
                removeFromCart(productId);
            } else {
                item.quantity = newQuantity;
                loadCart();
                updateCartCount();
            }
        }

        function removeFromCart(productId) {
            cart = cart.filter(item => item.id !== productId);
            loadCart();
            updateCartCount();
            showAlert('Product removed from cart!', 'warning');
        }

        function updateCartTotals() {
            const subtotal = cart.reduce((sum, item) => sum + (item.price * item.quantity), 0);
            const shipping = cart.length > 0 ? 50 : 0;
            const total = subtotal + shipping;

            document.getElementById('cart-subtotal').textContent = '৳' + subtotal;
            document.getElementById('cart-total').textContent = '৳' + total;
        }

        function applyFilters() {
            const searchTerm = document.getElementById('search-input').value.toLowerCase();
            const maxPrice = parseInt(document.getElementById('price-range').value);
            const selectedCategories = [];
            const sortBy = document.getElementById('sort-select').value;

            // Get selected categories
            const categoryCheckboxes = document.querySelectorAll('.category-filter input[type="checkbox"]:checked');
            categoryCheckboxes.forEach(checkbox => {
                selectedCategories.push(checkbox.value);
            });

            // Build query parameters
            const params = new URLSearchParams();
            params.append('get_products', '1');
            params.append('search', searchTerm);
            params.append('min_price', '0');
            params.append('max_price', maxPrice);
            if (selectedCategories.length > 0) {
                params.append('categories', selectedCategories.join(','));
            }
            if (sortBy) {
                params.append('sort', sortBy);
            }

            fetch(`products.php?${params.toString()}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        filteredProducts = data.products;
                        renderProducts();
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function clearFilters() {
            document.getElementById('search-input').value = '';
            document.getElementById('price-range').value = 1000;
            document.getElementById('price-display').textContent = '৳1000';
            document.getElementById('sort-select').value = '';
            
            const categoryCheckboxes = document.querySelectorAll('.category-filter input[type="checkbox"]');
            categoryCheckboxes.forEach(checkbox => {
                checkbox.checked = false;
            });

            loadProducts();
        }

        function showLoginModal() {
            const modal = new bootstrap.Modal(document.getElementById('loginModal'));
            modal.show();
        }

        function showRegisterModal() {
            const modal = new bootstrap.Modal(document.getElementById('registerModal'));
            modal.show();
        }

        function handleLogin(e) {
            e.preventDefault();
            const email = document.getElementById('login-email').value;
            const password = document.getElementById('login-password').value;

            fetch('auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `login=1&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    currentUser = data.user;
                    updateUserInterface();
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('loginModal'));
                    modal.hide();
                    
                    showAlert('Login successful!', 'success');
                } else {
                    showAlert(data.message || 'Login failed', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Login failed', 'danger');
            });
        }

        function handleRegister(e) {
            e.preventDefault();
            const name = document.getElementById('register-name').value;
            const email = document.getElementById('register-email').value;
            const password = document.getElementById('register-password').value;
            const confirmPassword = document.getElementById('register-confirm-password').value;

            if (password !== confirmPassword) {
                showAlert('Passwords do not match!', 'danger');
                return;
            }

            fetch('auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `register=1&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&password=${encodeURIComponent(password)}&confirm_password=${encodeURIComponent(confirmPassword)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    currentUser = data.user;
                    updateUserInterface();
                    
                    const modal = bootstrap.Modal.getInstance(document.getElementById('registerModal'));
                    modal.hide();
                    
                    showAlert('Registration successful!', 'success');
                } else {
                    showAlert(data.message || 'Registration failed', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Registration failed', 'danger');
            });
        }

        function logout() {
            fetch('auth.php?logout=1')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        currentUser = null;
                        updateUserInterface();
                        showAlert('Logged out successfully!', 'info');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function checkUserSession() {
            fetch('auth.php?get_user=1')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        currentUser = data.user;
                    }
                    updateUserInterface();
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function updateUserInterface() {
            const userNameSpan = document.getElementById('user-name');
            const loggedOutMenu = document.getElementById('logged-out-menu');
            const loggedInMenu = document.getElementById('logged-in-menu');

            if (currentUser) {
                userNameSpan.textContent = currentUser.name;
                loggedOutMenu.style.display = 'none';
                loggedInMenu.style.display = 'block';
            } else {
                userNameSpan.textContent = 'Account';
                loggedOutMenu.style.display = 'block';
                loggedInMenu.style.display = 'none';
            }
        }

        function loadProfile() {
            if (!currentUser) return;
            
            fetch('auth.php?get_user=1')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        document.getElementById('profile-name').value = data.user.name || '';
                        document.getElementById('profile-email').value = data.user.email || '';
                        document.getElementById('profile-phone').value = data.user.phone || '';
                        document.getElementById('profile-address').value = data.user.address || '';
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function handleProfileUpdate(e) {
            e.preventDefault();
            if (!currentUser) return;

            const name = document.getElementById('profile-name').value;
            const email = document.getElementById('profile-email').value;
            const phone = document.getElementById('profile-phone').value;
            const address = document.getElementById('profile-address').value;

            fetch('auth.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `update_profile=1&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&phone=${encodeURIComponent(phone)}&address=${encodeURIComponent(address)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    currentUser = data.user;
                    updateUserInterface();
                    showAlert('Profile updated successfully!', 'success');
                } else {
                    showAlert(data.message || 'Profile update failed', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Profile update failed', 'danger');
            });
        }

        function handleContact(e) {
            e.preventDefault();
            const name = document.getElementById('contact-name').value;
            const email = document.getElementById('contact-email').value;
            const message = document.getElementById('contact-message').value;

            fetch('contact.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `send_message=1&name=${encodeURIComponent(name)}&email=${encodeURIComponent(email)}&message=${encodeURIComponent(message)}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    showAlert(data.message, 'success');
                    document.getElementById('contact-form').reset();
                } else {
                    showAlert(data.message || 'Message sending failed', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Message sending failed', 'danger');
            });
        }

        function checkout() {
            if (!currentUser) {
                showAlert('Please login to proceed with checkout!', 'warning');
                showLoginModal();
                return;
            }

            if (cart.length === 0) {
                showAlert('Your cart is empty!', 'warning');
                return;
            }

            fetch('orders.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/x-www-form-urlencoded',
                },
                body: `create_order=1&cart=${encodeURIComponent(JSON.stringify(cart))}`
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    // Clear cart
                    cart = [];
                    updateCartCount();
                    loadCart();
                    
                    showAlert('Order placed successfully! Thank you for your purchase.', 'success');
                    showSection('orders');
                    loadOrders();
                } else {
                    showAlert(data.message || 'Checkout failed', 'danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                showAlert('Checkout failed', 'danger');
            });
        }

        function loadOrders() {
            if (!currentUser) return;

            fetch('orders.php?get_orders=1')
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const ordersList = document.getElementById('orders-list');
                        ordersList.innerHTML = '';

                        if (data.orders.length === 0) {
                            ordersList.innerHTML = '<p>No orders found.</p>';
                            return;
                        }

                        data.orders.forEach(order => {
                            const orderCard = document.createElement('div');
                            orderCard.className = 'card mb-3';
                            orderCard.innerHTML = `
                                <div class="card-body">
                                    <h5 class="card-title">Order #${order.id}</h5>
                                    <p class="card-text">Date: ${order.created_at}</p>
                                    <p class="card-text">Status: <span class="badge bg-info">${order.status}</span></p>
                                    <p class="card-text">Total: ৳${order.total}</p>
                                    <p class="card-text">Items: ${order.item_count}</p>
                                    <button class="btn btn-sm btn-primary" onclick="viewOrderDetails(${order.id})">
                                        View Details
                                    </button>
                                </div>
                            `;
                            ordersList.appendChild(orderCard);
                        });
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                });
        }

        function viewOrderDetails(orderId) {
            fetch(`orders.php?get_order=1&id=${orderId}`)
                .then(response => response.json())
                .then(data => {
                    if (data.status === 'success') {
                        const order = data.order;
                        const modal = new bootstrap.Modal(document.createElement('div'));
                        
                        const modalContent = `
                            <div class="modal-dialog modal-lg">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title">Order #${order.id}</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                    </div>
                                    <div class="modal-body">
                                        <div class="row mb-3">
                                            <div class="col-md-6">
                                                <p><strong>Date:</strong> ${order.created_at}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Status:</strong> <span class="badge bg-info">${order.status}</span></p>
                                            </div>
                                        </div>
                                        
                                        <h6>Order Items</h6>
                                        <div class="table-responsive">
                                            <table class="table">
                                                <thead>
                                                    <tr>
                                                        <th>Product</th>
                                                        <th>Price</th>
                                                        <th>Quantity</th>
                                                        <th>Subtotal</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    ${order.items.map(item => `
                                                        <tr>
                                                            <td>
                                                                <div class="d-flex align-items-center">
                                                                    <img src="${item.image}" class="img-thumbnail me-2" width="50" height="50">
                                                                    ${item.name}
                                                                </div>
                                                            </td>
                                                            <td>৳${item.price}</td>
                                                            <td>${item.quantity}</td>
                                                            <td>৳${item.subtotal}</td>
                                                        </tr>
                                                    `).join('')}
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="3" class="text-end"><strong>Total:</strong></td>
                                                        <td><strong>৳${order.total}</strong></td>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        `;
                        
                        modal._element.innerHTML = modalContent;
                        modal.show();
                    } else {
                        showAlert(data.message || 'Failed to load order details', 'danger');
                    }
                })
                .catch(error => {
                    console.error('Error:', error);
                    showAlert('Failed to load order details', 'danger');
                });
        }

        function showAlert(message, type) {
            const alertContainer = document.getElementById('alert-container');
            const alert = document.createElement('div');
            alert.className = `alert alert-${type} alert-dismissible fade show`;
            alert.innerHTML = `
                ${message}
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            `;
            alertContainer.appendChild(alert);

            // Auto-dismiss after 5 seconds
            setTimeout(() => {
                if (alert.parentNode) {
                    alert.remove();
                }
            }, 5000);
        }
    </script>
</body>
</html>