<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'conn.php'; // Adjust the path if necessary

// Check if user is logged in and is a user
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Get the product ID from the URL
if (isset($_GET['id'])) {
    $product_id = intval($_GET['id']);

    // Fetch product details from the database
    $sql = "SELECT p_name, p_price, p_category FROM products WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();

    if ($product) {

        // Insert product into the cart
        $sql = "INSERT INTO cart (p_name, p_price, p_category, user_id) VALUES (?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssi", $product['p_name'], $product['p_price'], $product['p_category'], $user_id);
        if ($stmt->execute()) {
            $_SESSION['success'] = "Product added to cart successfully.";
        } else {
            $_SESSION['error'] = "Failed to add product to cart.";
        }
        $stmt->close();
    } else {
        $_SESSION['error'] = "Product not found.";
    }
} else {
    $_SESSION['error'] = "Invalid product ID.";
}

$conn->close();

// Redirect to the products page
header('Location: ../dashboard/user/cart.php');
exit();
?>
