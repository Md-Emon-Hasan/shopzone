<?php
require_once 'config.php';

// Check if user is logged in
if (!isset($_SESSION['user'])) {
    echo json_encode(['status' => 'error', 'message' => 'Please login to access orders']);
    exit;
}

$user_id = $_SESSION['user']['id'];

// Create new order
if (isset($_POST['create_order'])) {
    $cart = json_decode($_POST['cart'], true);
    
    if (empty($cart)) {
        echo json_encode(['status' => 'error', 'message' => 'Cart is empty']);
        exit;
    }

    // Calculate total
    $total = 50; // Shipping cost
    foreach ($cart as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    // Start transaction
    $conn->begin_transaction();

    try {
        // Create order
        $stmt = $conn->prepare("INSERT INTO orders (user_id, total) VALUES (?, ?)");
        $stmt->bind_param("id", $user_id, $total);
        $stmt->execute();
        $order_id = $stmt->insert_id;

        // Add order items
        $stmt = $conn->prepare("INSERT INTO order_items (order_id, product_id, quantity, price) VALUES (?, ?, ?, ?)");
        foreach ($cart as $item) {
            $stmt->bind_param("iiid", $order_id, $item['id'], $item['quantity'], $item['price']);
            $stmt->execute();
        }

        // Commit transaction
        $conn->commit();

        echo json_encode(['status' => 'success', 'message' => 'Order placed successfully', 'order_id' => $order_id]);
    } catch (Exception $e) {
        // Rollback on error
        $conn->rollback();
        echo json_encode(['status' => 'error', 'message' => 'Order failed: ' . $e->getMessage()]);
    }
}

// Get user orders
if (isset($_GET['get_orders'])) {
    $stmt = $conn->prepare("
        SELECT o.*, 
               (SELECT COUNT(*) FROM order_items WHERE order_id = o.id) AS item_count
        FROM orders o
        WHERE o.user_id = ?
        ORDER BY o.created_at DESC
    ");
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $orders = $result->fetch_all(MYSQLI_ASSOC);

    echo json_encode(['status' => 'success', 'orders' => $orders]);
}

// Get order details
if (isset($_GET['get_order'])) {
    $order_id = (int)$_GET['id'];
    
    // Verify order belongs to user
    $stmt = $conn->prepare("SELECT id FROM orders WHERE id = ? AND user_id = ?");
    $stmt->bind_param("ii", $order_id, $user_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Order not found']);
        exit;
    }

    // Get order details
    $stmt = $conn->prepare("
        SELECT o.*, 
               oi.id AS item_id, oi.product_id, oi.quantity, oi.price,
               p.name, p.image
        FROM orders o
        JOIN order_items oi ON o.id = oi.order_id
        JOIN products p ON oi.product_id = p.id
        WHERE o.id = ?
    ");
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $items = $result->fetch_all(MYSQLI_ASSOC);

    if (!empty($items)) {
        $order = [
            'id' => $items[0]['id'],
            'total' => $items[0]['total'],
            'status' => $items[0]['status'],
            'created_at' => $items[0]['created_at'],
            'items' => array_map(function($item) {
                return [
                    'product_id' => $item['product_id'],
                    'name' => $item['name'],
                    'image' => $item['image'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price'],
                    'subtotal' => $item['price'] * $item['quantity']
                ];
            }, $items)
        ];

        echo json_encode(['status' => 'success', 'order' => $order]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Order items not found']);
    }
}
?>