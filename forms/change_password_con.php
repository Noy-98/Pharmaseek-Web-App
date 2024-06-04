<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);

    if (strlen($password) < 6 || strlen($password) > 20) {
        $_SESSION['error'] = 'Password must be between 6 and 20 characters.';
        header('Location: ../change_password.php');
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = 'Passwords do not match.';
        header('Location: ../change_password.php');
        exit();
    }

    // Select query to check if the user exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 0) {
        $_SESSION['error'] = 'User not found.';
        header('Location: ../change_password.php');
        exit();
    }

    // Hash the new password
    $hashed_password = password_hash($password, PASSWORD_BCRYPT);

    // Update the password in the user table
    $sql = "UPDATE users SET password = ? WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $hashed_password, $email);

    if ($stmt->execute()) {
        $_SESSION['success'] = 'Password updated successfully.';
        header('Location: ../login.php');
        exit();
    } else {
        $_SESSION['error'] = 'Failed to update the password. Please try again.';
        header('Location: ../change_password.php');
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>
