<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php'); // your DB connection file

// Ensure an ID is provided
if (!isset($_GET['id'])) {
    $_SESSION['error'] = "No assessment selected.";
    header("Location: assessment_view.php");
    exit;
}

$id = intval($_GET['id']);
$query = $conn->prepare("SELECT * FROM assessments_tb WHERE id = ?");
$query->bind_param("i", $id);
$query->execute();
$result = $query->get_result();

if ($result->num_rows === 0) {
    $_SESSION['error'] = "Assessment not found.";
    header("Location: assessment_view.php");
    exit;
}

$assessment = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Edit Assessment</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<?php include('../include/navbar.php'); ?>

<!-- Main Content -->
  <div class="container my-5">
    <div class="row justify-content-center">
      <div class="col-md-8">


          <!-- Page Header -->
        <div class="card shadow-sm">
          <div class="card-body">
  <div class="d-flex justify-content-between align-items-center mb-4">
          <h4 class="mb-0"><i class="bi bi-pencil-fill"></i> Edit Assessment</h4>
    <a href="assessment_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Assessments
    </a>
  </div>


  <?php
  if (!empty($_SESSION['error'])) {
      echo '<div class="alert alert-danger">'.$_SESSION['error'].'</div>';
      unset($_SESSION['error']);
  }
  if (!empty($_SESSION['success'])) {
      echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
      unset($_SESSION['success']);
  }
  ?>

  <form action="assessment_edit_proc.php" method="POST">
    <input type="hidden" name="id" value="<?= htmlspecialchars($assessment['id']) ?>">

    <div class="mb-3">
      <label for="student_id" class="form-label">Student ID</label>
      <input type="text" class="form-control" id="student_id" name="student_id" value="<?= htmlspecialchars($assessment['student_id']) ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="subject" class="form-label">Subject</label>
      <input type="text" class="form-control" id="subject" name="subject" value="<?= htmlspecialchars($assessment['subject']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="score" class="form-label">Score</label>
      <input type="number" class="form-control" id="score" name="score" value="<?= htmlspecialchars($assessment['score']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="term" class="form-label">Term</label>
      <input type="text" class="form-control" id="term" name="term" value="<?= htmlspecialchars($assessment['term']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="remarks" class="form-label">Remarks</label>
      <textarea class="form-control" id="remarks" name="remarks" rows="3"><?= htmlspecialchars($assessment['remarks']) ?></textarea>
    </div>

    <!-- Buttons -->
              <div class="d-flex justify-content-between">
    <a href="assessment_view.php" class="btn btn-outline-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Update Assessment</button>
  </form>
</div>

<?php include('../include/footer.php'); ?>
</body>
</html>
