<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

// Handle search input
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Fetch students (filtered or all)
try {
    if (!empty($search)) {
        $stmt = $conn->prepare("SELECT * FROM students 
                                WHERE first_name LIKE :search 
                                OR last_name LIKE :search 
                                OR class LIKE :search 
                                OR gender LIKE :search 
                                OR parent_phone LIKE :search 
                                ORDER BY student_id ASC");
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $stmt = $conn->query("SELECT * FROM students ORDER BY student_id ASC");
    }
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    $students = [];
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Students - NewSchool</title>
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
    <h2 class="text-primary"><i class="bi bi-people-fill"></i> Student List</h2>
    <a href="student_register.php" class="btn btn-primary">
      <i class="bi bi-plus-circle-fill"></i> Add Student
    </a>
  </div>

  <!-- Search Bar 
  <form method="GET" class="mb-4">
    <div class="input-group">
      <input 
        type="text" 
        name="search" 
        class="form-control" 
        placeholder="Search by name, class, gender, or parent's phone" 
        value="<?= htmlspecialchars($search) ?>" 
      >
      <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Search</button>
      <?php if (!empty($search)): ?>
        <a href="student_view.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</a>
      <?php endif; ?>
    </div>
    -->
  </form>

  <!-- Success/Error Alerts -->
  <?php if (isset($_SESSION['success'])): ?>
    <div class="alert alert-success"><?php echo $_SESSION['success']; unset($_SESSION['success']); ?></div>
  <?php endif; ?>
  <?php if (isset($_SESSION['error'])): ?>
    <div class="alert alert-danger"><?php echo $_SESSION['error']; unset($_SESSION['error']); ?></div>
  <?php endif; ?>

  <!-- Student Table -->
  <div class="card shadow-sm">
    <div class="card-body table-responsive">
      <table class="table table-hover align-middle table-bordered table-striped " id="table">
        <thead class="table-active">
          <tr>
            <th>ID</th>
            <th>Full Name</th>
            <th>Class</th>
            <th>Gender</th>
            <th>Date of Birth</th>
            <th>Parent's Phone</th>
            <th>Photo</th>
            <th>Reg. No</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          <?php if (count($students) > 0): ?>
            <?php foreach ($students as $student): ?>
              <tr>
                <td><?= $student['student_id']; ?></td>
                <td><?= htmlspecialchars($student['first_name'] . ' ' . $student['last_name']); ?></td>
                <td><?= htmlspecialchars($student['class']); ?></td>
                <td><?= htmlspecialchars($student['gender']); ?></td>
                <td><?= htmlspecialchars($student['date_of_birth']); ?></td>
                <td><?= htmlspecialchars($student['parent_phone']); ?></td>
                
<td>
  <?php if (!empty($student['photo'])): ?>
    <img src="../uploads/students/<?= htmlspecialchars($student['photo']); ?>" alt="Student Photo" width="50" height="50" style="object-fit: cover; border-radius: 50%;">
  <?php else: ?>
    <span class="text-muted">No Photo</span>
  <?php endif; ?>
</td>
<td><?= htmlspecialchars($student['registration_no']); ?></td>

                <td>
                    <a href="student_edit.php?student_id=<?= $student['student_id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                    <a href="student_delete.php?student_id=<?= $student['student_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this student?');"><i class="bi bi-trash"></i></a>
                  </td>
              </tr>
            <?php endforeach; ?>
          <?php else: ?>
            <tr>
              <td colspan="7" class="text-center text-muted">No students found.</td>
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
