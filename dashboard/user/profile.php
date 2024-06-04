<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
	header('Location: ../../login.php');
	exit();
}
require_once __DIR__ . '/../../forms/conn.php'; // Adjust the path if necessary

// Fetch user data from the database
$user_id = $_SESSION['user_id'];
$sql = "SELECT username, first_name, last_name, email, address, mobile_number, profile_picture FROM users WHERE id = ?";
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

    <title>PHARMASEEK</title>

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>

	<!-- My CSS -->
	<link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link href="../../assets/css/profile.css" rel="stylesheet">
</head>
<body>


	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="#" class="brand">
			<i class='bx bxs-store'></i>
			<span class="text">UserHub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="../user/home.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Dashboard</span>
				</a>
			</li>
            <li>
				<a href="../user/products.php">
					<i class='bx bxs-capsule'></i>
					<span class="text">Products</span>
				</a>
			</li>
            <li>
				<a href="../user/cart.php">
					<i class='bx bxs-cart-add' ></i>
					<span class="text">Cart</span>
				</a>
			</li>
			<li class="active">
				<a href="../user/profile.php">
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
			<form method="POST" action="#" onsubmit="return false;">
				<div class="form-input">
					<input type="search" id="search-input" name="query" placeholder="Search..." title="Enter search keyword" oninput="filterSearch()">
					<button type="submit" class="search-btn"><i class='bx bx-search'></i></button>
					<div id="search-results" class="search-results"></div>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="../user/profile.php" class="profile">
				<img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Profile Dashboard</h1>
					<ul class="breadcrumb">
						<li>
							<a href="#">Profile Dashboard</a>
						</li>
						<li><i class='bx bx-chevron-right' ></i></li>
						<li>
							<a class="active" href="../user/home.php">Home</a>
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
            
            <!-- Page content -->
            <div class="row">
                <div class="col-xl-4 order-xl-2 mb-5 mb-xl-0">
                    <div class="card card-profile shadow">
                        <div class="row justify-content-center">
                            <div class="col-lg-3 order-lg-2">
                                <div class="card-profile-image">
                                    <a href="#">
                                        <img src="<?php echo htmlspecialchars($user_data['profile_picture']); ?>"
                                            class="rounded-circle">
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body pt-0 pt-md-4">
                            <div class="text-center">
                                <h3>
                                Username: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['username']); ?></span>
                                </h3>
                                <hr class="my-4">
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                    First Name: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['first_name']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                    Last Name: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['last_name']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                    Email: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['email']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                    Mobile Number: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['mobile_number']); ?></span>
                                    </h3>
                                </div>
                                <hr class="my-4">
                                <hr class="my-4">
                                <div class="h5 font-weight-300">
                                    <h3>
                                    Address: <span class="font-weight-light"><?php echo htmlspecialchars($user_data['address']); ?></span>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 order-xl-1">
                    <div class="card bg-secondary shadow">
                        <div class="card-header bg-white border-0">
                            <div class="row align-items-center">
                                <div class="col-8">
                                    <h3 class="mb-0">My account</h3>
                                </div>
                                <div class="col-4 text-right">
                                <button type="button" class="btn btn-sm btn-primary" id="uploadButton">Upload Picture</button>
                                    <form id="uploadForm" method="post" action="../../forms/user_upload_picture.php" enctype="multipart/form-data" style="display: none;">
                                        <input type="file" id="profilePictureInput" name="profile_picture" accept="image/*">
                                    </form>
                                  </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <form method="post" action="../../forms/user_profile.php">
                                <h6 class="heading-small text-muted mb-4">User information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-username">Username</label>
                                                <input type="text" name="username" class="form-control form-control-alternative"
                                                    placeholder="Username" value="<?php echo htmlspecialchars($user_data['username']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group">
                                                <label class="form-control-label" for="input-email">Email address</label>
                                                <input type="email" name="email" class="form-control form-control-alternative"
                                                    placeholder="email" value="<?php echo htmlspecialchars($user_data['email']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-first-name">First name</label>
                                                <input type="text" name="first_name"
                                                    class="form-control form-control-alternative" placeholder="First name"
                                                    value="<?php echo htmlspecialchars($user_data['first_name']); ?>" required>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-last-name">Last name</label>
                                                <input type="text" name="last_name"
                                                    class="form-control form-control-alternative" placeholder="Last name"
                                                    value="<?php echo htmlspecialchars($user_data['last_name']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-first-name">New Password</label>
                                                <div class="password-wrapper">
                                                <input type="password" name="password" class="form-control form-control-alternative" placeholder="New Password" required>
                                                    <i class="bi bi-eye-slash" id="togglePassword1"></i>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-6">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-first-name">Confirm Password</label>
                                                <div class="password-wrapper">
                                                <input type="password" name="confirm_password" class="form-control form-control-alternative" placeholder="Confirm Password" required>
                                                    <i class="bi bi-eye-slash" id="togglePassword2"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <hr class="my-4">
                                <!-- Address -->
                                <h6 class="heading-small text-muted mb-4">Contact information</h6>
                                <div class="pl-lg-4">
                                    <div class="row">
                                        <div class="col-md-12">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-address">Address</label>
                                                <input name="address" class="form-control form-control-alternative"
                                                    placeholder="Home Address" type="text" value="<?php echo htmlspecialchars($user_data['address']); ?>" required>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-4">
                                            <div class="form-group focused">
                                                <label class="form-control-label" for="input-city">Mobile Number</label>
                                                <input type="text" name="mobile_number" class="form-control form-control-alternative"
                                                    placeholder="Mobile Number" value="<?php echo htmlspecialchars($user_data['mobile_number']); ?>" required>
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
            </div>
            </main>
            <!-- MAIN -->
	</section>
    
    <!-- Template Main JS File -->
	<script src="../../assets/js/dashboard.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script>
        document.getElementById('uploadButton').addEventListener('click', function() {
            document.getElementById('profilePictureInput').click();
        });

        document.getElementById('profilePictureInput').addEventListener('change', function() {
            document.getElementById('uploadForm').submit();
        });
    </script>
    <script>
    const sidebarItems = [
      { name: 'Dashboard', url: '../../dashboard/user/home.php' },
      { name: 'Products', url: '../../dashboard/user/products.php' },
      { name: 'Cart', url: '../../dashboard/user/cart.php' },
	  { name: 'Profile', url: '../../dashboard/user/profile.php' },
      { name: 'Pain Relief', url: '../../dashboard/user/products_pain_relief_category.php' },
	  { name: 'Respiratory & Allergies', url: '../../dashboard/user/products_respiratory_allergies_category.php' },
	  { name: 'Eye & Ear Care', url: '../../dashboard/user/products_eye_ear_care_category.php' },
	  { name: 'Foot & Leg Care', url: '../../dashboard/user/products_foot_leg_care_category.php' },
	  { name: 'Oral Care', url: '../../dashboard/user/products_oral_care_category.php' },
	  { name: 'Digestive Care', url: '../../dashboard/user/products_digestive_care_category.php' }
      
    ];

    function filterSearch() {
      const query = document.getElementById('search-input').value.toLowerCase();
      const resultsContainer = document.getElementById('search-results');
      resultsContainer.innerHTML = '';

      if (query) {
        const filteredItems = sidebarItems.filter(item => item.name.toLowerCase().includes(query));
        filteredItems.forEach(item => {
          const div = document.createElement('div');
          div.textContent = item.name;
          div.onclick = () => {
            window.location.href = item.url;
          };
          resultsContainer.appendChild(div);
        });
      }
    }
  </script>
</body>
</html>