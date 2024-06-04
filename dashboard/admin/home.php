<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'admin') {
	header('Location: ../../login.php');
	exit();
}
require_once __DIR__ . '/../../forms/conn.php'; // Adjust the path if necessary

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT profile_picture FROM users WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
$user_data = $result->fetch_assoc();
$stmt->close();

// Fetch total number of items in the cart
$sql_cart_count = "SELECT COUNT(*) AS total_items FROM cart";
$stmt_cart_count = $conn->prepare($sql_cart_count);
$stmt_cart_count->execute();
$result_cart_count = $stmt_cart_count->get_result();
$cart_count = $result_cart_count->fetch_assoc()['total_items'];
$stmt_cart_count->close();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- Favicons -->
	<link href="../../assets/img/pharmaseek_logo.png" rel="icon">

	<title>PHARMASEEK</title>

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="../../assets/css/dashboard.css">
</head>

<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-store'></i>
			<span class="text">AdminHub</span>
		</a>
		<ul class="side-menu top">
			<li class="active">
				<a href="../admin/home.php">
					<i class='bx bxs-dashboard'></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
			<li>
				<a href="../admin/view_products.php">
					<i class='bx bxs-spreadsheet'></i>
					<span class="text">View Products</span>
				</a>
			</li>
			<li>
				<a href="../admin/add_products.php">
					<i class='bx bxs-add-to-queue'></i>
					<span class="text">Add Products</span>
				</a>
			</li>
			<li>
				<a href="../admin/user_control.php">
					<i class='bx bxs-group'></i>
					<span class="text">User Control</span>
				</a>
			</li>
			<li>
				<a href="../admin/profile.php">
					<i class='bx bxs-user-circle'></i>
					<span class="text">Profile</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="../../forms/logout_con.php" class="logout">
					<i class='bx bxs-log-out-circle'></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu'></i>
			<a href="#" class="nav-link">PHARMASEEK</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="../admin/profile.php" class="profile">
				<img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right'></i></li>
						<li>
							<a class="active" href="../admin/home.php">Home</a>
						</li>
					</ul>
				</div>
			</div>

			<div class="message">
				<!-- Validation message section -->
				<?php
				if (session_status() == PHP_SESSION_NONE) {
					session_start(); // Start the session if it hasn't started
				}

				// Display error messages
				if (isset($_SESSION['error'])) {
					echo '<div class="error_message">' . $_SESSION['error'] . '</div>';
					unset($_SESSION['error']); // Clear the error message
				}

				// Display success messages
				if (isset($_SESSION['success'])) {
					echo '<div class="success_message">' . $_SESSION['success'] . '</div>';
					unset($_SESSION['success']); // Clear the success message
				}
				?>
			</div>

			<div class="col-sm-2 custom-width">
				<ul class="box-info">
					<li>
						<i class='bx bxs-calendar-check'></i>
						<span class="text">
							<h3><?php echo $cart_count; ?></h3>
							<p>New Order</p>
						</span>
					</li>
				</ul>
			</div>


			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>Recent Orders</h3>
					</div>
					<table>
						<thead>
							<tr>
								<th>User</th>
								<th>Product Name</th>
								<th>Product Price</th>
								<th>Product Category</th>
								<th>Date Order</th>
								<th>Status</th>
							</tr>
						</thead>
						<tbody>
						<?php
                            // Display recent orders
                            $sql_orders = "SELECT u.profile_picture, u.username, c.order_date, c.p_name, c.p_price, c.p_category
                                           FROM cart c
                                           INNER JOIN users u ON c.user_id = u.id
                                           ORDER BY c.order_date, c.p_name, c.p_price, c.p_category DESC";
                            $result_orders = $conn->query($sql_orders);
                            if ($result_orders->num_rows > 0) {
                                while ($row = $result_orders->fetch_assoc()) {
                                    echo "<tr>";
                                    echo "<td>";
                                    echo "<img src='" . htmlspecialchars($row['profile_picture']) . "' alt='Profile Image'>";
                                    echo "<p>" . htmlspecialchars($row['username']) . "</p>";
                                    echo "</td>";
									echo "<td>" . htmlspecialchars($row['p_name']) . "</td>";
									echo "<td>" . htmlspecialchars($row['p_price']) . "</td>";
									echo "<td>" . htmlspecialchars($row['p_category']) . "</td>";
                                    echo "<td>" . htmlspecialchars($row['order_date']) . "</td>";
									echo "<td><span class='status pending'>Pending</span></td>";
                                }
                            } else {
                                echo "<tr><td colspan='2'>No recent orders found.</td></tr>";
                            }
                            ?>
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->


	<script src="../../assets/js/dashboard.js"></script>
</body>

</html>