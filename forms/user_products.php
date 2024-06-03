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

// Fetch user data from the database
$sql = "SELECT id, p_name, p_price, p_category FROM products";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo "<tr>
                <td>".htmlspecialchars($row['p_name'])."</td>
                <td>".htmlspecialchars($row['p_price'])."</td>
                <td>".htmlspecialchars($row['p_category'])."</td>
                <td>
                    <a href='../../forms/user_order_products.php?id=".urlencode($row['id'])."' onclick='return confirm(\"Are you sure you want to order this products?\");'>
                        <span class='status completed'>Order</span>
                    </a>
                </td>
              </tr>";
    }
} else {
    echo "<tr><td colspan='5'>No products found</td></tr>";
}
$conn->close();
?>
