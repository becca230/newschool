<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

// === FETCH DASHBOARD STATS ===
try {
    // Students count
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM students");
    $total_students = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Teachers count
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM teachers");
    $total_teachers = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Parents count
    $stmt = $conn->query("SELECT COUNT(*) AS total FROM parents");
    $total_parents = (int) $stmt->fetch(PDO::FETCH_ASSOC)['total'];

    // Finances placeholder (no table yet)
    $total_finances = 0;
} catch (PDOException $e) {
    $total_students = $total_teachers = $total_parents = $total_finances = 0;
    // Optional debug line:
    // echo "Error: " . $e->getMessage();
}
?>

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
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

  <!-- Navbar -->
  <?php include('../include/navbar_main.php'); ?>

  <!-- Main Content -->
  <div class="container px-4" style="height: 60vh;">
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-4 pb-3 mb-4 border-bottom">
      <h1 class="h2 text-primary"><i class="bi bi-speedometer2"></i> Dashboard</h1>
    </div>

    <!-- Dashboard Cards -->
    <div class="row g-4">
      <!-- Students -->
      <div class="col-md-3">
        <a href="student_view.php" class="text-decoration-none text-dark">
          <div class="card dashboard-card text-center shadow-sm">
            <div class="card-body">
              <i class="bi bi-person-badge display-5 text-primary"></i>
              <h5 class="card-title mt-2">Students</h5>
              <p class="card-text fs-4 fw-bold"><?= $total_students ?></p>
            </div>
          </div>
        </a>
      </div>

      <!-- Teachers -->
      <div class="col-md-3">
        <a href="teacher_view.php" class="text-decoration-none text-dark">
          <div class="card dashboard-card text-center shadow-sm">
            <div class="card-body">
              <i class="bi bi-people display-5 text-primary"></i>
              <h5 class="card-title mt-2">Teachers</h5>
              <p class="card-text fs-4 fw-bold"><?= $total_teachers ?></p>
            </div>
          </div>
        </a>
      </div>

      <!-- Parents -->
      <div class="col-md-3">
        <a href="parent_view.php" class="text-decoration-none text-dark">
          <div class="card dashboard-card text-center shadow-sm">
            <div class="card-body">
              <i class="bi bi-heart display-5 text-primary"></i>
              <h5 class="card-title mt-2">Parents</h5>
              <p class="card-text fs-4 fw-bold"><?= $total_parents ?></p>
            </div>
          </div>
        </a>
      </div>

      <!-- Finances (placeholder) -->
      <div class="col-md-3">
        <div class="card dashboard-card text-center shadow-sm">
          <div class="card-body">
            <i class="bi bi-cash-coin display-5 text-primary"></i>
            <h5 class="card-title mt-2">Finances</h5>
            <p class="card-text fs-4 fw-bold">$<?= number_format($total_finances, 2) ?></p>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Footer -->
  <?php include('../include/footer.php'); ?>

  <!-- Bootstrap JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
