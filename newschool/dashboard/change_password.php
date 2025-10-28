<?php
session_start();

// Redirect if not logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Change Password - NewSchool</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php include('../include/navbar_main.php'); ?>

<div class="container my-5" style="max-width: 500px;">
  <div class="card shadow-sm">
    <div class="card-body">
      <h4 class="text-center text-primary mb-4">
        <i class="bi bi-key-fill"></i> Change Password
      </h4>

      <!-- Feedback Messages -->
      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <!-- Password Change Form -->
      <form method="POST" action="change_password_proc.php">
        <div class="mb-3">
          <label for="old_password" class="form-label">Old Password</label>
          <input type="password" class="form-control" id="old_password" name="old_password" required>
        </div>

        <div class="mb-3">
          <label for="new_password" class="form-label">New Password</label>
          <input type="password" class="form-control" id="new_password" name="new_password" required>
        </div>

        <div class="mb-3">
          <label for="confirm_password" class="form-label">Confirm New Password</label>
          <input type="password" class="form-control" id="confirm_password" name="confirm_password" required>
        </div>

        <button type="submit" class="btn btn-primary w-100">
          <i class="bi bi-save"></i> Update Password
        </button>
      </form>
    </div>
  </div>
</div>

<?php include('../include/footer.php'); ?>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
