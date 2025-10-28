<?php
session_start();
include('../include/db_connect.php');

// Fetch distinct subjects from teachers table
try {
    $stmt = $conn->query("SELECT DISTINCT subject FROM teachers ORDER BY subject ASC");
    $subjects = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $subjects = [];
    $_SESSION['error'] = "Error fetching subjects: " . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Add Assessment - NewSchool</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

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
            <h4 class="mb-0"><i class="bi bi-clipboard2-check"></i> Add Assessment</h4>
  </div>

            <!-- Display messages -->
            <?php
            if (isset($_SESSION['error'])) {
                echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            if (isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                unset($_SESSION['success']);
            }
            ?>

            <form action="assessment_add_proc.php" method="POST">

            <div class="row">
              <!-- Select Class -->
    <div class="col-6 mb-3">
      <label for="class" class="form-label">Class</label>
      <select name="class" id="class" class="form-control" required>
        <option value="">-- Select Class --</option>
        <?php
        $stmt = $conn->query("SELECT DISTINCT class FROM students ORDER BY class ASC");
        while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
            echo '<option value="'.$row['class'].'">'.$row['class'].'</option>';
        }
        ?>
      </select>
    </div>

   <!-- Student Dropdown (populated dynamically) -->

<div class="col-6 mb-3">
                <label for="child_name" class="form-label">Student</label>
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

              </div>

              <div class="row">

              <!-- Session -->
              <div class="col-6 mb-3">
                <label for="session" class="form-label">Session</label>
                <input type="text" class="form-control" id="session" name="session" placeholder="2024/2025" required>
              </div>

              <!-- Term -->
              <div class="col-6 mb-3">
                <label for="term" class="form-label">Term</label>
                <select class="form-select" id="term" name="term" required>
                  <option value="">-- Select Term --</option>
                  <option value="First Term">First Term</option>
                  <option value="Second Term">Second Term</option>
                  <option value="Third Term">Third Term</option>
                </select>
              </div>
              </div>

              <div class="row">
    <!-- Teacher -->
<div class="col-6 mb-3">
  <label for="teacher_id" class="form-label">Teacher</label>
  <select class="form-select" id="teacher_id" name="teacher_id" required>
    <option value="">-- Select Teacher --</option>
    <?php
      $teachers = $conn->query("SELECT teacher_id, full_name, subject FROM teachers ORDER BY full_name ASC");
      while ($teacher = $teachers->fetch(PDO::FETCH_ASSOC)) {
          echo "<option value='".$teacher['teacher_id']."'>".$teacher['full_name']." (".$teacher['subject'].")</option>";
      }
    ?>
  </select>
</div>


              <!-- Subject (from teachers table) -->
              <div class="col-6 mb-3">
                <label for="subject" class="form-label">Subject</label>
                <select class="form-select" id="subject" name="subject" required>
                  <option value="">-- Select Subject --</option>
                  <?php
                  if (!empty($subjects)) {
                      foreach ($subjects as $subj) {
                          echo '<option value="'.$subj['subject'].'">'.$subj['subject'].'</option>';
                      }
                  } else {
                      echo '<option value="">No subjects available</option>';
                  }
                  ?>
                </select>
              </div>
              </div>

              <!-- Assessments -->
              <div class="row">
                <div class="col-md-6 mb-3">
                  <label for="first_assignment" class="form-label">First Assignment</label>
                  <input type="number" class="form-control" id="first_assignment" name="first_assignment" min="0" max="20" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="second_assignment" class="form-label">Second Assignment</label>
                  <input type="number" class="form-control" id="second_assignment" name="second_assignment" min="0" max="20" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="first_test" class="form-label">First Test</label>
                  <input type="number" class="form-control" id="first_test" name="first_test" min="0" max="20" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="second_test" class="form-label">Second Test</label>
                  <input type="number" class="form-control" id="second_test" name="second_test" min="0" max="20" required>
                </div>
                <div class="col-md-6 mb-3">
                  <label for="exam" class="form-label">Exam</label>
                  <input type="number" class="form-control" id="exam" name="exam" min="0" max="60" required>
                </div>
              </div>

              <!-- Submit -->
              <div class="d-grid">
                <button type="submit" class="btn btn-primary">
                  <i class="bi bi-save"></i> Save Assessment
                </button>
              </div>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <?php include('../include/footer.php'); ?>
  <!-- jQuery for AJAX -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
document.getElementById('class').addEventListener('change', function() {
    var selectedClass = this.value;  // NOT className, use 'class'
    var xhr = new XMLHttpRequest();
    xhr.open('POST', 'fetch_students.php', true);
    xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
    xhr.onload = function() {
        if (this.status == 200) {
            document.getElementById('student').innerHTML = this.responseText;
        }
    };
    xhr.send('class=' + encodeURIComponent(selectedClass));
});
</script>



</body>
</html>
