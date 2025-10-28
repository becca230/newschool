<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

// Check if parent_id is passed
if (!isset($_GET['parent_id'])) {
    $_SESSION['error'] = "No parent ID provided.";
    header("Location: parent_view.php");
    exit;
}

$parent_id = intval($_GET['parent_id']);

try {
    // Fetch parent data
    $stmt = $conn->prepare("SELECT * FROM parents WHERE parent_id = :parent_id LIMIT 1");
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
    $stmt->execute();
    $parent = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$parent) {
        $_SESSION['error'] = "Parent not found.";
        header("Location: parent_view.php");
        exit;
    }
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: parent_view.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Edit Parent - NewSchool</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <!-- Custom CSS -->
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
          <h4 class="mb-0"><i class="bi bi-pencil-fill"></i> Edit Parent</h4>
    <a href="parent_view.php" class="btn btn-outline-secondary">
      <i class="bi bi-people-fill"></i> View Parents
    </a>
  </div>
 

          <form action="parent_edit_proc.php" method="POST">
            <input type="hidden" name="parent_id" value="<?= htmlspecialchars($parent['parent_id']); ?>">

            <!-- First Name -->
            <div class="mb-3">
              <label for="first_name" class="form-label">First Name</label>
              <input type="text" class="form-control" id="first_name" name="first_name"
                     value="<?= htmlspecialchars($parent['first_name']); ?>" required>
            </div>

            <!-- Last Name -->
            <div class="mb-3">
              <label for="last_name" class="form-label">Last Name</label>
              <input type="text" class="form-control" id="last_name" name="last_name"
                     value="<?= htmlspecialchars($parent['last_name']); ?>" required>

            <!-- Email -->
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email"
                     value="<?= htmlspecialchars($parent['email']); ?>" required>
            </div>

            <!-- Phone -->
            <div class="mb-3">
              <label for="phone" class="form-label">Phone</label>
              <input type="tel" class="form-control" id="phone" name="phone"
                     value="<?= htmlspecialchars($parent['phone']); ?>" required>
            </div>

            <!-- Address -->
            <div class="mb-3">
              <label for="address" class="form-label">Address</label>
              <textarea class="form-control" id="address" name="address" rows="3" required><?= htmlspecialchars($parent['address']); ?></textarea>
            </div>

            <!-- Relationship -->
            <div class="mb-3">
              <label for="relationship" class="form-label">Relationship</label>
              <select class="form-select" id="relationship" name="relationship" required>
                <option value="Father" <?= ($parent['relationship']=="Father")?"selected":""; ?>>Father</option>
                <option value="Mother" <?= ($parent['relationship']=="Mother")?"selected":""; ?>>Mother</option>
                <option value="Guardian" <?= ($parent['relationship']=="Guardian")?"selected":""; ?>>Guardian</option>
              </select>
            </div>

            <!-- Student ID -->
            <div class="mb-3">
              <label for="student_id" class="form-label">Student ID</label>
              <input type="text" class="form-control" id="student_id" name="student_id"
                     value="<?= htmlspecialchars($parent['student_id']); ?>" required>
            </div>

    <!-- Buttons -->
              <div class="d-flex justify-content-between">
    <a href="parent_view.php" class="btn btn-outline-secondary">Cancel</a>
    <button type="submit" class="btn btn-primary">Update Parent</button>
            
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include('../include/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
