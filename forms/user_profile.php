<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
    header('Location: ../login.php');
    exit();
}
require_once 'conn.php'; // Adjust the path if necessary

// Handle form submission to update profile
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    $username = $_POST['username'];
    $email = $_POST['email'];
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $address = $_POST['address'];
    $mobile_number = $_POST['mobile_number'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if (strlen($password) < 6) {
        $_SESSION['error'] = 'Password must be at least 6 characters long.';
        header('Location: ../dashboard/user/profile.php');
        exit();
    }

    if ($password !== $confirm_password) {
        $_SESSION['error'] = "Passwords do not match.";
        header('Location: ../dashboard/user/profile.php');
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Update user data in the database
    $sql_update = "UPDATE users SET username = ?, email = ?, first_name = ?, last_name = ?, address = ?, mobile_number = ?, password = ? WHERE id = ?";
    $stmt_update = $conn->prepare($sql_update);
    $stmt_update->bind_param("sssssssi", $username, $email, $first_name, $last_name, $address, $mobile_number, $hashed_password, $user_id);
    if ($stmt_update->execute()) {
        $_SESSION['success'] = "Profile updated successfully.";
        header('Location: ../dashboard/user/profile.php');
    } else {
        $_SESSION['error'] = "Error updating profile.";
        header('Location: ../dashboard/user/profile.php');
    }
    $stmt_update->close();
}

$db_con->close();

header('Location: ../dashboard/user/profile.php');
exit();
?>
