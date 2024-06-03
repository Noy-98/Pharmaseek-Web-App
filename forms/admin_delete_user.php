<?php
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
require_once 'conn.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}

if (isset($_GET['email'])) {
    $email = $_GET['email'];

    $stmt = $conn->prepare("DELETE FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = "User deleted successfully.";
    } else {
        $_SESSION['error'] = "Error deleting user.";
    }

    $stmt->close();
} else {
    $_SESSION['error'] = "Invalid request.";
}

$conn->close();

header('Location: ../dashboard/admin/user_control.php');
exit();
?>
