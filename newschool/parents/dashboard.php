<?php
include('../include/auth_check.php');
include('../include/db_connect.php');
include('../include/navbar_main.php');
?>

<body class="theme-parent">
  <div class="container mt-4">
    <h2 class="fw-bold text-warning mb-4">👩‍👧 Parent Dashboard</h2>

    <div class="row g-3">
      <div class="col-md-6">
        <div class="card shadow-sm p-3">
          <h5>Child’s Performance</h5>
          <p class="fs-4 fw-bold text-warning">Excellent</p>
        </div>
      </div>
      <div class="col-md-6">
        <div class="card shadow-sm p-3">
          <h5>Attendance</h5>
          <p class="fs-4 fw-bold text-warning">96%</p>
        </div>
      </div>
    </div>
  </div>

<?php include('../include/footer.php'); ?>
</body>
