<?php
session_start();
require_once 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Validate the email
    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        // Check if there's already a password reset request for this email
        $sql = "SELECT status FROM password_reset_requests WHERE email = ? ORDER BY request_date DESC LIMIT 1";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $request = $result->fetch_assoc();
            if ($request['status'] === 'pending') {
                $_SESSION['error'] = 'Your email is in processing.';
                header('Location: ../forgot_password.php');
                exit();
            } elseif ($request['status'] === 'approved') {
                $_SESSION['success'] = 'Your password reset request has been approved. The request is valid for 1 minute.';
                header('Location: ../change_password.php');
                exit();
            } elseif ($request['status'] === 'decline') {
                $_SESSION['error'] = 'Your email is decline';
                header('Location: ../forgot_password.php');
                exit();
            }
        }

        // If no previous request or status is not pending/approved, proceed to create a new request
        $sql = "SELECT id, username FROM users WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $user = $result->fetch_assoc();
            $user_id = $user['id'];
            $username = $user['username'];

            // Insert the request into the `password_reset_requests` table
            $sql = "INSERT INTO password_reset_requests (user_id, email, status) VALUES (?, ?, 'pending')";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("is", $user_id, $email);
            if ($stmt->execute()) {
                $_SESSION['success'] = 'Password reset request has been sent for approval.';
                header('Location: ../forgot_password.php');
                exit();
            } else {
                $_SESSION['error'] = 'Failed to submit the request. Please try again.';
                header('Location: ../forgot_password.php');
                exit();
            }
        } else {
            $_SESSION['error'] = 'Email not found in the system.';
            header('Location: ../forgot_password.php');
            exit();
        }

        $stmt->close();
    } else {
        $_SESSION['error'] = 'Invalid email address.';
        header('Location: ../forgot_password.php');
        exit();
    }

    $db_con->close();
    header('Location: ../forgot_password.php');
    exit();
}
?>
