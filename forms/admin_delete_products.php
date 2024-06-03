<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'conn.php'; // Adjust the path if necessary

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM products WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Products deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting this products.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

$conn->close();

header('Location: ../dashboard/admin/view_products.php');
exit();
?>
