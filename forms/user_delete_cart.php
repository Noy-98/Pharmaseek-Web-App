<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'conn.php'; // Adjust the path if necessary

// Check if user is logged in and is an admin
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("DELETE FROM cart WHERE id = ?");
    $stmt->bind_param("i", $id);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Item deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting this Item.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

$db_con->close();

header('Location: ../dashboard/user/cart.php');
exit();
?>
