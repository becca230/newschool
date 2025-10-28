<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

// Check teacher_id
if (!isset($_GET['teacher_id'])) {
    $_SESSION['error'] = "No teacher selected.";
    header("Location: teacher_view.php");
    exit;
}

$teacher_id = $_GET['teacher_id'];

// Fetch teacher
try {
    $stmt = $conn->prepare("SELECT * FROM teachers WHERE teacher_id = ?");
    $stmt->execute([$teacher_id]);
    $teacher = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$teacher) {
        $_SESSION['error'] = "Teacher not found.";
        header("Location: teacher_view.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: teacher_view.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Teacher</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">
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
          <h4 class="mb-0"><i class="bi bi-pencil-fill"></i> Edit Teacher</h4>
    <a href="teacher_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Teachers
    </a>
  </div>

  <form action="teacher_edit_proc.php" method="POST">
    <input type="hidden" name="teacher_id" value="<?php echo $teacher['teacher_id']; ?>">

    <div class="mb-3">
      <label class="form-label">Full Name</label>
      <input type="text" name="full_name" class="form-control" required value="<?php echo htmlspecialchars($teacher['full_name']); ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Subject</label>
      <select class="form-select" name="subject" required>
        <option value="Mathematics" <?php if ($teacher['subject'] === 'Mathematics') echo 'selected'; ?>>Mathematics</option>
        <option value="English" <?php if ($teacher['subject'] === 'English') echo 'selected'; ?>>English</option>
        <option value="Science" <?php if ($teacher['subject'] === 'Science') echo 'selected'; ?>>Science</option>
        <option value="Arts" <?php if ($teacher['subject'] === 'Arts') echo 'selected'; ?>>Arts</option>
      </select>
    </div>

    <div class="mb-3">
      <label class="form-label">Email</label>
      <input type="email" name="email" class="form-control" required value="<?php echo htmlspecialchars($teacher['email']); ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Phone</label>
      <input type="text" name="phone" class="form-control" required value="<?php echo htmlspecialchars($teacher['phone']); ?>">
    </div>

    <div class="mb-3">
      <label class="form-label">Address</label>
      <textarea name="address" class="form-control" rows="3" required><?php echo htmlspecialchars($teacher['address']); ?></textarea>
    </div>

    <!-- Buttons -->
              <div class="d-flex justify-content-between">
    <a href="teacher_view.php" class="btn btn-outline-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Update Teacher</button>
  </form>
</div>
      </div>
    </div>
  </div>
</div>

<?php include('../include/footer.php'); ?>

</body>
</html>
