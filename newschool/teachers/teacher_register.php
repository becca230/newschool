<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Teacher - NewSchool</title>
  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Bootstrap Icons -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
  <link rel="stylesheet" href="../css/styles.css">
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
            <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Register New Teacher</h4>
    <a href="teacher_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Teachers
    </a>
  </div>

          
            
            <form action="teacher_register_proc.php" method="POST">

            <div class="row">
              <!-- Full Name -->
              <div class="col-6 mb-3">
                <label for="full_name" class="form-label">Full Name</label>
                <input type="text" class="form-control" id="full_name" name="full_name" placeholder="Enter teacher's full name" required>
              </div>


              <!-- Subject -->
              <div class="col-6 mb-3">
                <label for="subject" class="form-label">Subject</label>
                <select class="form-select" id="subject" name="subject" required>
                  <option value=""> -- Select Subject -- </option>
                  <option value="Mathematics">Mathematics</option>
                  <option value="English">English</option>
                  <option value="Science">Science</option>
                  <option value="Arts">Arts</option>
                </select>
              </div>
              </div>

            <div class="row">
              <!-- Email -->
              <div class="col-6 mb-3">
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter teacher's email" required>
              </div>

              <!-- Phone -->
              <div class="col-6 mb-3">
                <label for="phone" class="form-label">Phone Number</label>
                <input type="tel" class="form-control" id="phone" name="phone" placeholder="+234 801 234 5678" required>
              </div>
              </div>

              <div class="row">
              <!-- Address -->
              <div class=" mb-3">
                <label for="address" class="form-label">Home Address</label>
                <textarea class="form-control" id="address" name="address" rows="3" placeholder="Enter teacher's home address" required></textarea>
              </div>
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary"><i class="bi bi-check-circle-fill"></i> Register Teacher</button>
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
