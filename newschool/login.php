<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login | School Management Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="css/styles.css">
</head>
<body>

  <!-- Navbar -->
  <?php include('include/navbar.php'); ?>

  <!-- Login Section -->
  <section class="login-section d-flex align-items-center justify-content-center py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

              <h3 class="text-center mb-4 text-primary fw-bold">
                <i class="bi bi-box-arrow-in-right"></i> Sign In
              </h3>

              <!-- Display errors or success messages -->
              <?php
              if (!empty($_SESSION['error'])) {
                  echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                  unset($_SESSION['error']);
              }
              if (!empty($_SESSION['success'])) {
                  echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                  unset($_SESSION['success']);
              }
              ?>

              <form action="login_proc.php" method="POST">
                <!-- Username/Email -->
                <div class="mb-3">
                  <label for="username" class="form-label">Username / Email</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-envelope-fill"></i></span>
                    <input type="text" class="form-control" id="username" name="username" placeholder="Enter Username or Email" required>
                  </div>
                </div>

                <!-- Password -->
                <div class="mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                  </div>
                </div>

                <div class="text-end mt-2">
  <a href="forgot_password.php" class="text-decoration-none">Forgot Password?</a>
</div>

                <!-- Submit Button -->
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-box-arrow-in-right"></i> Sign In
                  </button>
                </div>
              </form>

              <p class="text-center mt-3 mb-0">
                Don't have an account? <a href="register.php" class="text-secondary">Register Here</a>
              </p>

            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include('include/footer.php'); ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
