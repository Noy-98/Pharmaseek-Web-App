<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate if mobile number exists in the database
    $stmt = $conn->prepare("SELECT id, password, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows == 0) {
        $_SESSION['error'] = 'Email not found.';
        header('Location: ../login.php');
        exit();
    }

    $stmt->bind_result($id, $hashed_password, $user_type);
    $stmt->fetch();

    // Validate password
    if (!password_verify($password, $hashed_password)) {
        $_SESSION['error'] = 'Incorrect password.';
        header('Location: ../login.php');
        exit();
    }

    // Validate user type and redirect accordingly
    if ($user_type == 'admin') {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_type'] = 'admin';
        header('Location: ../dashboard/admin/home.php');
    } elseif ($user_type == 'user') {
        $_SESSION['user_id'] = $id;
        $_SESSION['user_type'] = 'user';
        header('Location: ../dashboard/user/home.php');
    } else {
        $_SESSION['error'] = 'Invalid user type.';
        header('Location: ../login.php');
    }

    $stmt->close();
    $conn->close();
}
?>
