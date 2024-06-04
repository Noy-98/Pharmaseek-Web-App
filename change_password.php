<?php
session_start(); // Start the session
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">

  <title>PHARMASEEK</title>
  <meta content="" name="description">
  <meta content="" name="keywords">

  <!-- Favicons -->
  <link href="assets/img/pharmaseek_logo.png" rel="icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Montserrat:300,300i,400,400i,500,500i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="assets/vendor/aos/aos.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
  <link href="assets/vendor/boxicons/css/boxicons.min.css" rel="stylesheet">
  <link href="assets/vendor/glightbox/css/glightbox.min.css" rel="stylesheet">
  <link href="assets/vendor/remixicon/remixicon.css" rel="stylesheet">
  <link href="assets/vendor/swiper/swiper-bundle.min.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="assets/css/style.css" rel="stylesheet">
</head>

<body>

  <!-- ======= Header ======= -->
  <header id="header" class="fixed-top d-flex align-items-center ">
    <div class="container d-flex align-items-center justify-content-between">

      <div class="logo">
        <h1><a href="index.html"><span>PHARMASEEK</span></a></h1>
      </div>

      <nav id="navbar" class="navbar">
        <ul>
          <li><a class="nav-link scrollto" href="index.html#hero">Home</a></li>
          <li><a class="nav-link scrollto" href="index.html#about">About</a></li>
          <li><a class="nav-link scrollto" href="index.html#contact">Contact</a></li>
          <li class="dropdown"><a href="#"><span>Portal</span> <i class="bi bi-chevron-down"></i></a>
            <ul>
              <li><a href="login.php">Login</a></li>
              <li><a href="signup.php">Signup</a></li>
              <li><a href="forgot_password.php">Forgot Password</a></li>
            </ul>
          </li>
        </ul>
        <i class="bi bi-list mobile-nav-toggle"></i>
      </nav><!-- .navbar -->

    </div>
  </header><!-- End Header -->

  <main id="main">

    <!-- ======= Breadcrumbs Section ======= -->
    <section class="breadcrumbs">
      <div class="container">

        <div class="d-flex justify-content-between align-items-center">
          <h2>Change Password Page</h2>
          <ol>
            <li><a href="index.html">Home</a></li>
            <li>Change Password Page</li>
          </ol>
        </div>

      </div>
    </section><!-- End Breadcrumbs Section -->

    <!-- ======= Login Section ======= -->
    <section id="login" class="contact">
      <div class="container">
        <div class="section-title" data-aos="fade-up">
          <h2>Portal</h2>
          <p>Change Password</p>
        </div>
          <div class="col-lg-12 mt-5 mt-lg-0" data-aos="fade-left" data-aos-delay="200">

            <form method="post" action="forms/change_password_con.php" class="php-email-form">
              <div class="row">
              </div>
              <div class="form-group mt-3">
                <input type="email" class="form-control" name="email" id="email" placeholder="Email" required>
              </div>
              <div class="form-group mt-3 pass">
              <input type="password" class="form-control" name="password" id="password" placeholder="New Password" required>
              <i class="bi bi-eye-slash" id="togglePassword1"></i>
            </div>
            <div class="form-group mt-3 pass">
              <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="Confirm Password" required>
              <i class="bi bi-eye-slash" id="togglePassword2"></i>
            </div>
              <div class="my-3">
              <!-- Validation message section -->
              <?php
              // Check if there are any error messages
              if (isset($_SESSION['error'])) {
                echo '<div class="error_message">' . $_SESSION['error'] . '</div>';
                unset($_SESSION['error']); // Clear the error message
              }

              // Check if there are any success messages
              if (isset($_SESSION['success'])) {
                echo '<div class="success_message">' . $_SESSION['success'] . '</div>';
                unset($_SESSION['success']); // Clear the success message
              }
              ?>
            </div>
              <div class="text-center"><button type="submit">Submit</button></div>
            </form>

          </div>
      </div>
    </section><!-- End Login Section -->

  </main><!-- End #main -->

 <!-- ======= Footer ======= -->
 <footer id="footer">
  <div class="footer-top">
    <div class="container">
      <div class="row">

        <div class="col-lg-4 col-md-6">
          <div class="footer-info">
            <h3>PHARMASEEK</h3>
            <p class="pb-3"><em>Your Trusted Source for Quality Pharmaceuticals and Healthcare Products...</em></p>
            <p>
              Makati City, Philippines<br><br>
              <strong>Phone:</strong> +63 9543456481<br>
              <strong>Email:</strong> pharmaseek@gmail.com<br>
            </p>
            <div class="social-links mt-3">
              <a href="#" class="twitter"><i class="bx bxl-twitter"></i></a>
              <a href="#" class="facebook"><i class="bx bxl-facebook"></i></a>
              <a href="#" class="instagram"><i class="bx bxl-instagram"></i></a>
              <a href="#" class="google-plus"><i class="bx bxl-skype"></i></a>
              <a href="#" class="linkedin"><i class="bx bxl-linkedin"></i></a>
            </div>
          </div>
        </div>

        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Useful Links</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="index.html#hero">Home</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="index.html#about">About us</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="index.html#contact">Contact</a></li>
          </ul>
        </div>

        <div class="col-lg-2 col-md-6 footer-links">
          <h4>Our Services</h4>
          <ul>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Medication Services</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Over The Counter</a></li>
            <li><i class="bx bx-chevron-right"></i> <a href="#">Cards & Gifts</a></li>
          </ul>
        </div>

        <div class="col-lg-4 col-md-6 footer-newsletter">
          <h4>Our Newsletter</h4>
          <p>Send a newsletter at Pharmaseek Online Store to receive the latest updates on promotions, health tips, and new arrivals</p>
          <form action="" method="post">
            <input type="email" name="email"><input type="submit" value="Subscribe">
          </form>

        </div>

      </div>
    </div>
  </div>

  <div class="container">
    <div class="copyright">
      &copy; Copyright <strong><span>PHARMASEEK</span></strong>. All Rights Reserved
    </div>
  </div>
</footer><!-- End Footer -->

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>
  <div id="preloader"></div>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter_vanilla.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>

</body>

</html>