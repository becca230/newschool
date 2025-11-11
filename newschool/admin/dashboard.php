<?php
include('../include/auth_check.php');
include('../include/db_connect.php');
include('../include/navbar_main.php');

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
  <title>Admin Dashboard</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet">
</head>
<body>
<?php include('../include/navbar.php'); ?>
<body class="theme-admin">
  <div class="container mt-4">
    <div class="container my-5">
  <h2>Welcome, <?= htmlspecialchars($_SESSION['username']); ?> (Admin)</h2>
  <p>Here you can manage all users, students, teachers, and parents.</p>

  <div class="row mt-4">
    <div class="col-md-4">
      <a href="../students/student_view.php" class="btn btn-outline-primary w-100">
        <p class="card-text fs-4 fw-bold"><?= $total_students ?></p>
        Manage Students</a>
      
              
    </div>
    <div class="col-md-4">
      <a href="../teachers/teacher_view.php" class="btn btn-outline-success w-100">
        <p class="card-text fs-4 fw-bold"><?= $total_teachers ?></p>
        Manage Teachers</a>
    </div>
    <div class="col-md-4">
      <a href="../parents/parent_view.php" class="btn btn-outline-warning w-100">
        <p class="card-text fs-4 fw-bold"><?= $total_parents ?></p>
        Manage Parents</a>
    </div>
  </div>
</div>
    </div>
  </div>

<?php include('../include/footer.php'); ?>
</body>
