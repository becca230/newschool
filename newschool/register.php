<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register | School Management Dashboard</title>
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

  <!-- Register Section -->
  <section class="register-section d-flex align-items-center justify-content-center py-5">
    <div class="container">
      <div class="row justify-content-center">
        <div class="col-md-6 col-lg-5">
          <div class="card shadow-lg border-0 rounded-4">
            <div class="card-body p-4">

              <h3 class="text-center mb-4 text-primary fw-bold">
                <i class="bi bi-person-plus-fill"></i> Register
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

              <?php unset($_POST['captcha_answer']); ?>

              <form action="register_proc.php" method="POST">

              <div class="row">
                <!-- First Name -->
                <div class="col-6 mb-3">
                  <label for="first_name" class="form-label">First Name</label>
                  <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter First Name" required>
                </div>

                <!-- Last Name -->
                <div class="col-6 mb-3">
                  <label for="last_name" class="form-label">Last Name</label>
                  <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter Last Name" required>
                </div>

                </div>

              <div class="row">
                <!-- Username -->
                <div class="col-6 mb-3">
                  <label for="username" class="form-label">Username/Email Address</label>
                  <input type="text" class="form-control" id="username" name="username" placeholder="Choose a Username/Enter Email Address" required>
                </div>

                <!-- Role -->
                <div class="col-6 mb-3">
                  <label for="role" class="form-label">Role</label>
                  <select class="form-select" id="role" name="role" required>
                    <option value="">-- Select Role --</option>
                    <option value="student">Student</option>
                    <option value="teacher">Teacher</option>
                    <option value="parent">Parent</option>
                    <option value="admin">Admin</option>
                  </select>
                </div>
            </div>

              <div class="row">
                <!-- Security Question -->
                <div class="col-6 mb-3">
                  <label for="security_question" class="form-label">Security Question</label>
                  <select class="form-select" id="security_question" name="security_question" required>
                    <option value="">-- Select Question --</option>
                    <option value="What is your mother's maiden name?">What is your mother's maiden name?</option>
                    <option value="What was the name of your first pet?">What was the name of your first pet?</option>
                    <option value="What was the make of your first car?">What was the make of your first car?</option>
                    <option value="In what city were you born?">In what city were you born?</option>
                  </select>
                </div>

                <!-- Security Answer -->
                <div class="col-6 mb-3">
                  <label for="security_answer" class="form-label">Security Answer</label>
                  <input type="text" class="form-control" id="security_answer" name="security_answer" placeholder="Enter Answer" required>
                </div>
              </div>

              <div class="row">
                <!-- Password -->
                <div class="col-6 mb-3">
                  <label for="password" class="form-label">Password</label>
                  <div class="input-group">
                    <span class="input-group-text"><i class="bi bi-lock-fill"></i></span>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter Password" required>
                  </div>
                </div>

                <!-- Math CAPTCHA -->
<div class="col-12 mb-6">
  <label class="form-label">Security Check</label>
  <div class="d-flex align-items-center gap-2">
    <span id="num1" class="fw-bold text-primary"></span>
    <span class="fw-bold"> + </span>
    <span id="num2" class="fw-bold text-primary"></span>
    <span class="fw-bold"> = </span>
    <input type="number" name="captcha_answer" id="captcha_answer" class="form-control w-25 no-arrows" required>
    <input type="hidden" name="captcha_sum" id="captcha_sum">
    <button type="button" class="btn btn-outline-secondary btn-sm" id="refreshCaptcha">
      <i class="bi bi-arrow-clockwise"></i>
    </button>
  </div>
  <small class="text-muted">Prove you’re human — solve the math question.</small>
</div>



                <!-- Submit Button -->
                <div class="d-grid">
                  <button type="submit" class="btn btn-primary btn-lg">
                    <i class="bi bi-person-plus-fill"></i> Register
                  </button>
                </div>
              </form>

              <p class="text-center mt-3 mb-0">
                Already have an account? <a href="login.php" class="text-secondary">Sign In</a>
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

  <script>
  function generateCaptcha() {
    const num1 = Math.floor(Math.random() * 90) + 10; // random two-digit
    const num2 = Math.floor(Math.random() * 90) + 10;
    document.getElementById('num1').textContent = num1;
    document.getElementById('num2').textContent = num2;
    document.getElementById('captcha_sum').value = num1 + num2;
  }

  document.getElementById('refreshCaptcha').addEventListener('click', generateCaptcha);
  window.onload = generateCaptcha;
</script>

</body>
</html>
