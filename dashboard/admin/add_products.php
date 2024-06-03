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
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

    <!-- Favicons -->
    <link href="../../assets/img/pharmaseek_logo.png" rel="icon">
	<link href="../../assets/css/profile.css" rel="stylesheet">

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
			<li>
				<a href="../admin/home.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
            <li>
				<a href="../admin/view_products.php">
                <i class='bx bxs-spreadsheet'></i>
					<span class="text">View Products</span>
				</a>
			</li>
            <li class="active">
				<a href="../admin/add_products.php">
				<i class='bx bxs-add-to-queue'></i>
					<span class="text">Add Products</span>
				</a>
			</li>
			<li>
				<a href="../admin/user_control.php">
					<i class='bx bxs-group' ></i>
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
					<i class='bx bxs-log-out-circle' ></i>
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
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">PHARMASEEK</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
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
					<h1>Add Products Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Add Products Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
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

			
                <div class="col-xl-12 order-xl-s add">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">Add Products</h3>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="../../forms/admin_add_products.php">
                                <h6 class="heading-small text-muted mb-4">Product information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <input type="hidden" name="product_id">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label">Product Name</label>
                                                <input type="text" name="product_name" class="form-control form-control-alternative"
                                                    placeholder="Product Name" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label">Product Price</label>
                                                <input type="number" name="product_price" class="form-control form-control-alternative"
                                                    placeholder="Product Price" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label">Product Pcs</label>
                                                <input type="text" name="product_pcs"
                                                    class="form-control form-control-alternative" placeholder="Product Pcs" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label">Product Category</label>
                                                <input type="text" name="product_category"
                                                    class="form-control form-control-alternative" placeholder="Product Category" required>
                                            </div>
                                        </div>
										<div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label">Product Stock</label>
                                                <input type="text" name="product_stock"
                                                    class="form-control form-control-alternative" placeholder="Product Stock" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-sm btn-primary" type="submit">Submit</button>
                                      </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            

		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="../../assets/js/dashboard.js"></script>
</body>
</html>