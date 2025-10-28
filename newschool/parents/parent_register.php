
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Parent - NewSchool</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/styles.css">
  <!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- Select2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

<!-- Select2 JS -->
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

<script>
$(document).ready(function() {
  $('#studentSelect').select2({
    placeholder: "Search or select a student",
    allowClear: true
  });
});
</script>

</head>
<body>

 <!-- Display messages -->
            <?php
            session_start();
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                unset($_SESSION['success']);
            }
            ?>

  <!-- Navbar -->
  <?php include('../include/navbar_main.php'); ?>

  <!-- Main Content -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">


        

            <!-- Page Header -->
        <div class="card shadow-sm">
          <div class="card-body">
  <div class="d-flex justify-content-between align-items-center mb-4">
            <h4 class="mb-0"><i class="bi bi-heart-fill"></i> Register New Parent</h4>
    <a href="parent_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Parents
    </a>
  </div>

            
            
            
            <form action="parent_register_proc.php" method="POST">
<div class="row">
              <!-- Name -->
              <div class="col-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter parent's first name" required>
              </div>

              <div class="col-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter parent's last name" required>
              </div>

              </div>

              <div class="row">
              <!-- Email -->
              <div class="col-6 mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter parent's email" required>
              </div>

              <!-- Phone -->
              <div class="col-6 mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+234 801 234 5678" required>
              </div>
              </div>

              <div class="row">
              <!-- Address -->
              <div class="col-6 mb-3">
                <label for="address" class="form-label">Home Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter parent's home address" required></textarea>
              </div>

              <!-- Relationship -->
              <div class="col-6 mb-3">
                <label for="relationship" class="form-label">Relationship</label>
                <select class="form-select" id="relationship" name="relationship" required>
                  <option value="">-- Select Relationship --</option>
                  <option value="Father">Father</option>
                  <option value="Mother">Mother</option>
                  <option value="Guardian">Guardian</option>
                </select>
              </div>
              </div>

              <div class="row">

              <div class="col-6 mb-3">
                <label for="child_name" class="form-label">Child's Name</label>
                <select id="studentSelect" class="form-control" name="student_id">
  <option value="">-- Select a Student --</option>
  <?php
  include('../include/db_connect.php');
  $stmt = $conn->query("SELECT student_id, first_name, last_name FROM students ORDER BY first_name ASC");
  while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
      echo '<option value="' . htmlspecialchars($row['student_id']) . '">'
          . htmlspecialchars($row['first_name'] . ' ' . $row['last_name'])
          . '</option>';
  }
  ?>
</select>

              </div>

              <!-- Student ID -->
              <div class="col-6 mb-3">
                <label for="student_id" class="form-label">Student ID</label>
                <input type="text" class="form-control" id="student_id" name="student_id" placeholder="Enter associated student ID" required>
              </div>
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Register Parent</button>
              </div>
            </form>
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
