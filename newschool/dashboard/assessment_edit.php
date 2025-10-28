<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php'); // Your PDO connection

// Ensure an ID is provided
if (!isset($_GET['assessment_id'])) {
    $_SESSION['error'] = "No assessment selected.";
    header("Location: assessment_view.php");
    exit;
}

$assessment_id = intval($_GET['assessment_id']);

// ✅ PDO version
$query = $conn->prepare("SELECT * FROM assessments WHERE assessment_id = :assessment_id");
$query->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);
$query->execute();
$assessment = $query->fetch(PDO::FETCH_ASSOC);

if (!$assessment) {
    $_SESSION['error'] = "Assessment not found.";
    header("Location: assessment_view.php");
    exit;
}
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

<div class="container py-4">
  <h2 class="mb-4">Edit Assessment</h2>

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
    <input type="hidden" name="assessment_id" value="<?= htmlspecialchars($assessment['assessment_id']) ?>">

    <div class="mb-3">
      <label for="student_id" class="form-label">Student ID</label>
      <input type="text" class="form-control" id="student_id" name="student_id"
             value="<?= htmlspecialchars($assessment['student_id']) ?>" readonly>
    </div>

    <div class="mb-3">
      <label for="subject" class="form-label">Subject</label>
      <input type="text" class="form-control" id="subject" name="subject"
             value="<?= htmlspecialchars($assessment['subject']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="score" class="form-label">Score</label>
      <input type="number" class="form-control" id="score" name="score"
             value="<?= htmlspecialchars($assessment['score']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="term" class="form-label">Term</label>
      <input type="text" class="form-control" id="term" name="term"
             value="<?= htmlspecialchars($assessment['term']) ?>" required>
    </div>

    <div class="mb-3">
      <label for="remarks" class="form-label">Remarks</label>
      <textarea class="form-control" id="remarks" name="remarks" rows="3"><?= htmlspecialchars($assessment['remarks']) ?></textarea>
    </div>

    <button type="submit" class="btn btn-primary">Update Assessment</button>
    <a href="assessment_view.php" class="btn btn-secondary">Cancel</a>
  </form>
</div>

<?php include('../include/footer.php'); ?>
</body>
</html>
