<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>About | School Management Dashboard</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

  <!-- Navbar -->
  <?php include('../include/navbar_main.php'); ?>

  <!-- About Section -->
  <section class="about-section py-5">
    <div class="container">
      <div class="row align-items-center mb-5">
        <div class="col-md-6">
          <img src="../images/side_outside.jpg" alt="About School Management" class="img-fluid rounded shadow" style=height:400px;>
        </div>
        <div class="col-md-6">
          <h2 class="text-primary fw-bold"><i class="bi bi-mortarboard-fill"></i> About Our Dashboard</h2>
          <p class="mt-3">
            The <strong>School Management Dashboard</strong> is built to simplify how schools handle 
            daily activities. From managing students, teachers, and parents to keeping track of 
            finances — everything is centralized in one powerful platform.
          </p>
          <p>
            Our mission is to create an easy-to-use, efficient, and secure tool that 
            helps schools focus more on education and less on paperwork.
          </p>
          <a href="contact.php" class="btn btn-primary mt-3">
            <i class="bi bi-envelope-fill"></i> Contact Us
          </a>
        </div>
      </div>

      <!-- Core Features -->
      <div class="row text-center g-4">
        <div class="col-md-3">
          <div class="card h-100 shadow-sm border-0 feature-card">
            <div class="card-body">
            <i class="bi bi-person-badge-fill display-5 text-primary"></i>
              <h5 class="mt-3">Student Management</h5>
              <p class="small">Register, track, and monitor student progress with ease.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 shadow-sm border-0 feature-card">
            <div class="card-body">
            <i class="bi bi-people-fill display-5 text-primary"></i>
              <h5 class="mt-3">Teacher Records</h5>
              <p class="small">Manage teacher profiles, subjects, and performance records.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 shadow-sm border-0 feature-card">
            <div class="card-body">
            <i class="bi bi-heart-fill display-5 text-primary"></i>
              <h5 class="mt-3">Parent Access</h5>
              <p class="small">Keep parents engaged with updates and performance insights.</p>
            </div>
          </div>
        </div>
        <div class="col-md-3">
          <div class="card h-100 shadow-sm border-0 feature-card">
            <div class="card-body">
            <i class="bi bi-cash-coin display-5 text-primary"></i>
              <h5 class="mt-3">Finance Tracking</h5>
              <p class="small">Stay on top of school budgets, fees, and expenses securely.</p>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <?php include('../include/footer.php'); ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
