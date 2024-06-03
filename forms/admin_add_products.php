<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
    header('Location: ../login.php');
    exit();
}
require_once 'conn.php'; // Adjust the path if necessary

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $product_id = isset($_POST['product_id']) ? $_POST['product_id'] : null;
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_pcs = $_POST['product_pcs'];
    $product_category = $_POST['product_category'];
    $product_stock = $_POST['product_stock'];

    if ($product_id) {
        // Update existing product
        $sql_update = "UPDATE products SET p_name = ?, p_price = ?, p_category = ?, p_stock = ?, p_pcs = ? WHERE id = ?";
        $stmt_update = $conn->prepare($sql_update);
        $stmt_update->bind_param("sssssi", $product_name, $product_price, $product_category, $product_stock, $product_pcs, $product_id);
        if ($stmt_update->execute()) {
            $_SESSION['success'] = "Product updated successfully.";
        } else {
            $_SESSION['error'] = "Error updating product.";
        }
        $stmt_update->close();
    } else {
        // Insert new product
        $sql_insert = "INSERT INTO products (p_name, p_price, p_category, p_stock, p_pcs) VALUES (?, ?, ?, ?, ?)";
        $stmt_insert = $conn->prepare($sql_insert);
        $stmt_insert->bind_param("sssss", $product_name, $product_price, $product_category, $product_stock, $product_pcs);
        if ($stmt_insert->execute()) {
            $_SESSION['success'] = "Product added successfully.";
        } else {
            $_SESSION['error'] = "Error adding product.";
        }
        $stmt_insert->close();
    }
}
$conn->close();

header('Location: ../dashboard/admin/add_products.php');
exit();
?>
