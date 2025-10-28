<?php
include('../include/auth_check.php');
include('../include/db_connect.php');
include('../include/navbar_main.php');
?>

<body class="theme-student">
  <div class="container mt-4">
    <h2 class="fw-bold text-info mb-4">🎓 Student Dashboard</h2>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h5>Assignments</h5>
          <p class="fs-4 fw-bold text-info">2 Pending</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h5>Results</h5>
          <p class="fs-4 fw-bold text-info">3.8 GPA</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h5>Attendance</h5>
          <p class="fs-4 fw-bold text-info">92%</p>
        </div>
      </div>
    </div>
  </div>

<?php include('../include/footer.php'); ?>
</body>
