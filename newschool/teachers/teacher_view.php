<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

// Handle search input
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Fetch teachers (filtered or all)
try {
    if (!empty($search)) {
        $stmt = $conn->prepare("SELECT * FROM teachers 
                                WHERE full_name LIKE :search 
                                OR subject LIKE :search 
                                OR email LIKE :search 
                                OR phone LIKE :search
                                ORDER BY teacher_id ASC");
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM teachers ORDER BY teacher_id ASC");
    }
    $teachers = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    $teachers = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Teachers</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

<?php include('../include/navbar_main.php'); ?>

<div class="container my-5">

  <!-- Page Header -->
  <div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="text-primary"><i class="bi bi-clipboard-data"></i> Teacher List</h2>
    <a href="teacher_register.php" class="btn btn-primary">
      <i class="bi bi-plus-circle-fill"></i> Add Teacher
    </a>
  </div>

  <!-- Search Bar 
  <form method="GET" class="mb-4">
    <div class="input-group">
      <input 
        type="text" 
        name="search" 
        class="form-control" 
        placeholder="Search by name, subject, email, or phone" 
        value="<?= htmlspecialchars($search) ?>"
      >
      <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Search</button>
      <?php if (!empty($search)): ?>
        <a href="teacher_view.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</a>
      <?php endif; ?>
    </div> -->
    
  </form>

  <!-- Flash Messages -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- Teacher Table -->
  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle table-bordered table-striped" id="table">
        <thead class="table-active">
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Subject</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Address</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($teachers) > 0): ?>
            <?php foreach ($teachers as $teacher): ?>
              <tr>
                <td><?= $teacher['teacher_id']; ?></td>
                <td><?= htmlspecialchars($teacher['full_name']); ?></td>
                <td><?= htmlspecialchars($teacher['subject']); ?></td>
                <td><?= htmlspecialchars($teacher['email']); ?></td>
                <td><?= htmlspecialchars($teacher['phone']); ?></td>
                <td><?= htmlspecialchars($teacher['address']); ?></td>
                <td>
                    <a  href="teacher_edit.php?teacher_id=<?= $teacher['teacher_id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                    <a  href="teacher_delete.php?teacher_id=<?= $teacher['teacher_id']; ?>" 
                     class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this teacher?');"><i class="bi bi-trash"></i></a>
                  </td>

              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No teachers found.</td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>

<?php include('../include/footer.php'); ?>

<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap5.min.js"></script>

<script>
  $(document).ready(function () {
    $('#table').DataTable({
      responsive: true,
      pageLength: 10,
      lengthMenu: [5, 10, 25, 50, 100],
      order: [[0, 'asc']]
    });
  });
</script>

</body>
</html>



