<?php
require_once 'config.php';

// Get all products
if (isset($_GET['get_products'])) {
    $search = isset($_GET['search']) ? "%".$_GET['search']."%" : "%";
    $min_price = isset($_GET['min_price']) ? (float)$_GET['min_price'] : 0;
    $max_price = isset($_GET['max_price']) ? (float)$_GET['max_price'] : 100000;
    $categories = isset($_GET['categories']) ? explode(',', $_GET['categories']) : [];
    $sort = isset($_GET['sort']) ? $_GET['sort'] : '';

    // Build query
    $query = "SELECT * FROM products WHERE name LIKE ? AND price BETWEEN ? AND ?";
    $params = [$search, $min_price, $max_price];
    $types = "sdd";

    // Add category filter if specified
    if (!empty($categories)) {
        $placeholders = implode(',', array_fill(0, count($categories), '?'));
        $query .= " AND category IN ($placeholders)";
        $types .= str_repeat('s', count($categories));
        $params = array_merge($params, $categories);
    }

    // Add sorting
    switch ($sort) {
        case 'price-low':
            $query .= " ORDER BY price ASC";
            break;
        case 'price-high':
            $query .= " ORDER BY price DESC";
            break;
        case 'name':
            $query .= " ORDER BY name ASC";
            break;
        default:
            $query .= " ORDER BY id DESC";
    }

    // Prepare and execute
    $stmt = $conn->prepare($query);
    $stmt->bind_param($types, ...$params);
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['status' => 'success', 'products' => $products]);
}

// Get featured products (first 4)
if (isset($_GET['get_featured'])) {
    $stmt = $conn->prepare("SELECT * FROM products ORDER BY id DESC LIMIT 4");
    $stmt->execute();
    $result = $stmt->get_result();
    $products = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['status' => 'success', 'products' => $products]);
}

// Get single product
if (isset($_GET['get_product'])) {
    $product_id = (int)$_GET['id'];
    $stmt = $conn->prepare("SELECT * FROM products WHERE id = ?");
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();

    if ($product) {
        echo json_encode(['status' => 'success', 'product' => $product]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Product not found']);
    }
}
?>