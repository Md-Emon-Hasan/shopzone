<?php
require_once 'config.php';

// Handle user registration
if (isset($_POST['register'])) {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);

    // Validate inputs
    if (empty($name) || empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'All fields are required']);
        exit;
    }

    if ($password !== $confirm_password) {
        echo json_encode(['status' => 'error', 'message' => 'Passwords do not match']);
        exit;
    }

    if (strlen($password) < 6) {
        echo json_encode(['status' => 'error', 'message' => 'Password must be at least 6 characters']);
        exit;
    }

    // Check if email already exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows > 0) {
        echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
        exit;
    }

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert new user
    $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $hashed_password);

    if ($stmt->execute()) {
        // Get the new user
        $user_id = $stmt->insert_id;
        $stmt = $conn->prepare("SELECT id, name, email FROM users WHERE id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        // Set session
        $_SESSION['user'] = $user;
        
        echo json_encode(['status' => 'success', 'message' => 'Registration successful', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Registration failed']);
    }
}

// Handle user login
if (isset($_POST['login'])) {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate inputs
    if (empty($email) || empty($password)) {
        echo json_encode(['status' => 'error', 'message' => 'Email and password are required']);
        exit;
    }

    // Get user by email
    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if ($user && password_verify($password, $user['password'])) {
        // Remove password before storing in session
        unset($user['password']);
        $_SESSION['user'] = $user;
        
        echo json_encode(['status' => 'success', 'message' => 'Login successful', 'user' => $user]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }
}

// Handle user logout
if (isset($_GET['logout'])) {
    session_destroy();
    echo json_encode(['status' => 'success', 'message' => 'Logged out successfully']);
}

// Get current user
if (isset($_GET['get_user'])) {
    if (isset($_SESSION['user'])) {
        echo json_encode(['status' => 'success', 'user' => $_SESSION['user']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'No user logged in']);
    }
}

// Update user profile
if (isset($_POST['update_profile'])) {
    if (!isset($_SESSION['user'])) {
        echo json_encode(['status' => 'error', 'message' => 'Please login to update profile']);
        exit;
    }

    $user_id = $_SESSION['user']['id'];
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $phone = trim($_POST['phone']);
    $address = trim($_POST['address']);

    // Validate inputs
    if (empty($name) || empty($email)) {
        echo json_encode(['status' => 'error', 'message' => 'Name and email are required']);
        exit;
    }

    // Check if email is being changed and already exists
    if ($email !== $_SESSION['user']['email']) {
        $stmt = $conn->prepare("SELECT id FROM users WHERE email = ? AND id != ?");
        $stmt->bind_param("si", $email, $user_id);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo json_encode(['status' => 'error', 'message' => 'Email already exists']);
            exit;
        }
    }

    // Update user
    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, address = ? WHERE id = ?");
    $stmt->bind_param("ssssi", $name, $email, $phone, $address, $user_id);

    if ($stmt->execute()) {
        // Update session
        $_SESSION['user']['name'] = $name;
        $_SESSION['user']['email'] = $email;
        
        echo json_encode(['status' => 'success', 'message' => 'Profile updated successfully', 'user' => $_SESSION['user']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Profile update failed']);
    }
}
?>