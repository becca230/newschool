<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>School Management Dashboard</title>
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

  <!-- Hero Section -->
  <section class="hero-section text-center d-flex align-items-center mb-5">
    <div class="container" style="height: 60vh;">
      <h1 class="display-4 fw-bold"><i class="bi bi-journal-bookmark"></i> Welcome to School Management Dashboard</h1>
      <p class="lead mt-3">A smart way to manage students, teachers, parents, and finances in one place.</p>
      <a href="register.php" class="btn btn-outline-secondary btn mt-4"><i class="bi bi-person-plus-fill"></i> Register New User</a>
      <a href="login.php" class="btn btn-primary btn mt-4"><i class="bi bi-box-arrow-in-right"></i> Sign In</a>

    </div>
  </section>

  <!-- Footer -->
  <?php include('include/footer.php'); ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
