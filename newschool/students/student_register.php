<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Register Student - NewSchool</title>
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
            <h4 class="mb-0"><i class="bi bi-person-plus-fill"></i> Register New Student</h4>
    <a href="student_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Students
    </a>
  </div> 
  

<form action="student_register_proc.php" method="POST" enctype="multipart/form-data">
              
            <div class="row">
              <!-- Student Name -->
              <div class="col-6 mb-3">
                <label for="first_name" class="form-label">First Name</label>
                <input type="text" class="form-control" id="first_name" name="first_name" placeholder="Enter student's first name" required>
              </div>

              <div class="col-6 mb-3">
                <label for="last_name" class="form-label">Last Name</label>
                <input type="text" class="form-control" id="last_name" name="last_name" placeholder="Enter student's last name" required>
              </div>
              </div>

            <div class="row">
              <!-- Gender -->
              <div class="col-6 mb-3">
                <label for="gender" class="form-label">Gender</label>
                <select class="form-select" id="gender" name="gender" required>
                  <option value="">-- Select Gender --</option>
                  <option value="Male">Male</option>
                  <option value="Female">Female</option>
                </select>
              </div>

              <!-- Date of Birth -->
              <div class="col-6 mb-3">
                <label for="date_of_birth" class="form-label">Date of Birth</label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-control" max="<?= date('Y-m-d'); ?>" required>

              </div>
              </div>

            <div class="row">
              <!-- Class -->
              <div class="col-6 mb-3">
                <label for="class" class="form-label">Class</label>
                <select class="form-select" id="class" name="class" required>
                  <option value="">-- Select Class --</option>
                  <option value="JSS1">JSS1</option>
                  <option value="JSS2">JSS2</option>
                  <option value="JSS3">JSS3</option>
                  <option value="SS1">SS1</option>
                  <option value="SS2">SS2</option>
                  <option value="SS3">SS3</option>
                </select>
              </div>

              <!-- Parent's Phone -->
              <div class="col-6 mb-3">
                <label for="parent_phone" class="form-label">Parent's Phone Number</label>
                <input type="tel" class="form-control" id="parent_phone" name="parent_phone" placeholder="Enter parent's phone number" required>
              </div>
              </div>

              <!-- Student Photo -->
              <div class="mb-3">
  <label for="photo" class="form-label">Student Photo</label>
  <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
</div>


              <!-- Buttons -->
              <div class="d-flex justify-content-between">
                <a href="student_view.php" class="btn btn-outline-secondary"><i class="bi bi-arrow-left-circle"></i> Back</a>
                <button type="submit" class="btn btn-primary"><i class="bi bi-save-fill"></i> Save Student</button>
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
