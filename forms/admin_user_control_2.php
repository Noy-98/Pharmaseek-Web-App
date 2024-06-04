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
$sql = "SELECT user_id, email, status, request_date FROM password_reset_requests";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".htmlspecialchars($row['user_id'])."</td>
                <td>".htmlspecialchars($row['email'])."</td>
                <td>".htmlspecialchars($row['status'])."</td>
                <td>".htmlspecialchars($row['request_date'])."</td>
                <td>
                    <a href='../../forms/admin_controls_approved.php?user_id=".urlencode($row['user_id'])."' onclick='return confirm(\"Are you sure you want to Approve this user request?\");'>
                        <span class='status completed'>Approve</span>
                    </a>
                </td>
                <td>
                    <a href='../../forms/admin_controls_decline.php?user_id=".urlencode($row['user_id']). "' onclick='return confirm(\"Are you sure you want Decline this user request?\");'>
                        <span class='status process'>Decline</span>
                    </a>
                </td>
                <td>
                    <a href='../../forms/admin_delete_2.php?user_id=". urlencode($row['user_id']) . "' onclick='return confirm(\"Are you sure you want Delete this user request?\");'>
                        <span class='status pending'>Delete</span>
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No Request Found</td></tr>";
}
?>

