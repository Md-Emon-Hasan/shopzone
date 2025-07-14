# **E-Commerce Website (ShopZone)**
<img width="1366" height="566" alt="Image" src="https://github.com/user-attachments/assets/e50e57df-425b-4445-bd84-f65eede10973" />

## **1. Project Overview**
**ShopZone** is a professional e-commerce platform built with PHP, MySQL, JavaScript (ES6+), HTML5, and CSS3. It includes:
- **User Authentication** (Login/Registration)
- **Product Management** (CRUD operations)
- **Shopping Cart & Checkout**
- **Order Processing**
- **Responsive UI** (Bootstrap 5)

---

## **2. System Architecture**
### **Frontend (Client-Side)**
| Technology | Purpose |
|------------|---------|
| **HTML5** | Page structure & content |
| **CSS3** | Styling & responsive design |
| **JavaScript (ES6+)** | Dynamic UI, form handling, API calls |
| **Bootstrap 5** | UI components & grid layout |
| **Font Awesome** | Icons |

### **Backend (Server-Side)**
| Technology | Purpose |
|------------|---------|
| **PHP** | Server-side logic, API endpoints |
| **MySQL** | Database storage |
| **MySQLi** | Secure database connections |

### **Database Schema**
- **Users** (`id`, `name`, `email`, `password`, `phone`, `address`)
- **Products** (`id`, `name`, `price`, `original_price`, `image`, `category`, `description`)
- **Orders** (`id`, `user_id`, `total`, `status`, `created_at`)
- **Order Items** (`id`, `order_id`, `product_id`, `quantity`, `price`)

---

## **3. Key Features & Workflow**
### **1. User Authentication**
- **Registration**  
  - Password hashed using `password_hash()` (bcrypt)  
  - Email uniqueness check  
- **Login**  
  - Password verified via `password_verify()`  
  - Session-based authentication  

### **2. Product Management**
- **Display Products**  
  - Fetched via `products.php?get_products=1` (AJAX)  
  - Filtering by **category, price range, search**  
  - Sorting (price low-high, A-Z)  
- **Featured Products**  
  - Loads latest 4 products (`products.php?get_featured=1`)  

### **3. Shopping Cart**
- **Client-Side Cart** (JavaScript array)  
  - Add/remove items  
  - Quantity adjustment  
  - Real-time total calculation  
- **Checkout**  
  - Validates user login  
  - Sends cart data to `orders.php`  
  - Creates order record in MySQL  

### **4. Order Processing**
- **Order Storage**  
  - Saved in `orders` & `order_items` tables  
- **Order History**  
  - Fetched via `orders.php?get_orders=1`  

---

## **4. API Endpoints (PHP)**
| File | Endpoint | Method | Description |
|------|----------|--------|-------------|
| `auth.php` | `?register=1` | POST | User registration |
| `auth.php` | `?login=1` | POST | User login |
| `auth.php` | `?logout=1` | GET | Logout user |
| `products.php` | `?get_products=1` | GET | Fetch all products (filterable) |
| `products.php` | `?get_featured=1` | GET | Fetch featured products |
| `orders.php` | `?create_order=1` | POST | Submit an order |
| `orders.php` | `?get_orders=1` | GET | Fetch user’s order history |

---

## **5. Setup Guide**
### **Prerequisites**
- **XAMPP/WAMP** (Apache + MySQL)  
- **PHP 7.4+**  
- **MySQL 5.7+**  

### **Installation Steps**
1. **Clone the project** into `htdocs` (XAMPP) or `www` (WAMP).
2. **Create a MySQL database** (`shopzone`) and import the SQL schema.
3. **Configure `config.php`** with your database credentials:
   ```php
   define('DB_HOST', 'localhost');
   define('DB_USER', 'root');
   define('DB_PASS', '');
   define('DB_NAME', 'shopzone');
   ```
4. **Run the project** at `http://localhost/shopzone`.

---

## **6. Security Measures**
1. **Password Encryption**  
   - Uses `password_hash()` (bcrypt) + `password_verify()`.
2. **SQL Injection Protection**  
   - Prepared statements (`MySQLi`).
3. **User Session Management**  
   - PHP `session_start()` with validation.
4. **Form Validation**  
   - Client-side (JavaScript) + Server-side (PHP).

---

## **7. Future Improvements**
- **Admin Dashboard** (Add/Edit products)  
- **Payment Gateway Integration** (Stripe/PayPal)  
- **Product Reviews & Ratings**  
- **Email Notifications** (Order confirmation)  

---

## **8. Conclusion**
This project demonstrates a **full-stack e-commerce system** with:
✔ **User authentication**  
✔ **Product filtering & sorting**  
✔ **Cart & checkout functionality**  
✔ **Order tracking**  
✔ **Responsive design**  

---

## Contact Information
- **Email:** [iconicemon01@gmail.com](mailto:iconicemon01@gmail.com)
- **WhatsApp:** [+8801834363533](https://wa.me/8801834363533)
- **GitHub:** [Md-Emon-Hasan](https://github.com/Md-Emon-Hasan)
- **LinkedIn:** [Md Emon Hasan](https://www.linkedin.com/in/md-emon-hasan-695483237/)
- **Facebook:** [Md Emon Hasan](https://www.facebook.com/mdemon.hasan2001/) 

---
