<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_type'] !== 'user') {
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



    <title>PHARMASEEK</title>

    <!-- Boxicons -->
    <link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
    <!-- My CSS -->
    <link rel="stylesheet" href="../../assets/css/dashboard.css">
    <link rel="stylesheet" href="../../assets/css/home.css">
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
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="../user/products.php">
                    <i class='bx bxs-capsule'></i>
                    <span class="text">Products</span>
                </a>
            </li>
            <li>
                <a href="../user/cart.php">
                    <i class='bx bxs-cart-add'></i>
                    <span class="text">Cart</span>
                </a>
            </li>
            <li>
                <a href="../user/profile.php">
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
                    <h1>Respiratory & Allergies Category</h1>
                    <ul class="breadcrumb">
                        <li>
                            <a href="#">Respiratory & Allergies Category</a>
                        </li>
                        <li><i class='bx bx-chevron-right'></i></li>
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
            <div class="table-data">
                <div class="todo">
                    <div class="order">
                        <div class="head">
                            <h3>List</h3>
                        </div>
                        <table>
                            <thead>
                                <tr>
                                    <th>Product Name</th>
                                    <th>Product Price</th>
                                    <th>Product Category</th>
                                    <th></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php include '../../forms/user_products_2.php'; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </main>
        <!-- MAIN -->
    </section>
    <!-- CONTENT -->


    <script src="../../assets/js/dashboard.js"></script>
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