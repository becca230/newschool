<?php
include('../include/auth_check.php');
include('../include/db_connect.php');
include('../include/navbar_main.php');
?>

<body class="theme-teacher">
  <div class="container mt-4">
    <h2 class="fw-bold text-success mb-4">👨‍🏫 Teacher Dashboard</h2>

    <div class="row g-3">
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h5>My Classes</h5>
          <p class="fs-4 fw-bold text-success">5</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h5>Assignments Due</h5>
          <p class="fs-4 fw-bold text-success">3</p>
        </div>
      </div>
      <div class="col-md-4">
        <div class="card shadow-sm p-3">
          <h5>Students</h5>
          <p class="fs-4 fw-bold text-success">120</p>
        </div>
      </div>
    </div>
  </div>

<?php include('../include/footer.php'); ?>
</body>
