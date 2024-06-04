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

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    // Prepare and execute the delete statement
    $stmt = $conn->prepare("UPDATE password_reset_requests SET status = 'decline' WHERE user_id = ?");
    $stmt->bind_param("i", $user_id); // "s" stands for string

    if ($stmt->execute()) {
        $_SESSION['success'] = "User Decline successfully.";
    } else {
        $_SESSION['error'] = "Error Declining user.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

$conn->close();

header('Location: ../dashboard/admin/user_control.php');
exit();
?>
