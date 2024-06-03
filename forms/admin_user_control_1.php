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

// Fetch user data from the database
$sql = "SELECT username, email, profile_picture, user_type FROM users";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>
                    <img src='".htmlspecialchars($row['profile_picture'])."'>
                    <p>".htmlspecialchars($row['username'])."</p>
                </td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['user_type'])."</td>
                <td>
                    <a href='../../forms/admin_delete_user.php?email=".urlencode($row['email'])."' onclick='return confirm(\"Are you sure you want to delete this user?\");'>
                        <span class='status pending'>Delete</span>
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No users found</td></tr>";
}
$conn->close();
?>
