<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

if (!isset($_GET['student_id'])) {
    $_SESSION['error'] = "Invalid request.";
    header("Location: student_view.php");
    exit;
}

$student_id = $_GET['student_id'];

try {
    $stmt = $conn->prepare("SELECT * FROM students WHERE student_id = :student_id LIMIT 1");
    $stmt->bindParam(':student_id', $student_id);
    $stmt->execute();
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header("Location: student_view.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: student_view.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Student - NewSchool</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="../css/styles.css" rel="stylesheet">
</head>
<body>

<?php include('../include/navbar_main.php'); ?>

  <!-- Main Content -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">


          <!-- Page Header -->
        <div class="card shadow-sm">
          <div class="card-body">
  <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="bi bi-pencil-fill"></i> Edit Student</h4>
    <a href="student_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Students
    </a>
  </div>

  <form action="student_edit_proc.php" method="POST" enctype="multipart/form-data">
    <input type="hidden" name="student_id" value="<?php echo htmlspecialchars($student['student_id']); ?>">

    <div class="mb-3">
      <label class="form-label">First Name</label>
      <input type="text" class="form-control" name="first_name" value="<?php echo htmlspecialchars($student['first_name']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Last Name</label>
      <input type="text" class="form-control" name="last_name" value="<?php echo htmlspecialchars($student['last_name']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Gender</label>
      <select class="form-select" name="gender" required>
        <option value="Male" <?php if ($student['gender'] === 'Male') echo 'selected'; ?>>Male</option>
        <option value="Female" <?php if ($student['gender'] === 'Female') echo 'selected'; ?>>Female</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Date of Birth</label>
      <input type="date" class="form-control" name="date_of_birth" value="<?php echo htmlspecialchars($student['date_of_birth']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Class</label>
      <input type="text" class="form-control" name="class" value="<?php echo htmlspecialchars($student['class']); ?>" required>
    </div>

    <div class="mb-3">
      <label class="form-label">Parent Phone</label>
      <input type="text" class="form-control" name="parent_phone" value="<?php echo htmlspecialchars($student['parent_phone']); ?>" required>
    </div>

    <div class="mb-3 text-center">
  <?php if (!empty($student['photo'])): ?>
    <img src="../uploads/students/<?= htmlspecialchars($student['photo']); ?>" 
         alt="Current Photo" 
         width="100" 
         height="100" 
         style="object-fit: cover; border-radius: 10px; margin-bottom: 10px;">
  <?php else: ?>
    <p class="text-muted">No photo uploaded.</p>
  <?php endif; ?>
</div>

<div class="mb-3">
  <label for="photo" class="form-label">Update Photo (optional)</label>
  <input type="file" class="form-control" id="photo" name="photo" accept="image/*">
  <small class="text-muted">Leave blank to keep current photo.</small>
</div>


    <!-- Buttons -->
              <div class="d-flex justify-content-between">
    <a href="student_view.php" class="btn btn-outline-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Update Student</button>

  </form>
</div>
      </div>
    </div>
  </div>
</div>

<?php include('../include/footer.php'); ?>
</body>
</html>
