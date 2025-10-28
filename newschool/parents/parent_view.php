<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

// Handle search
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
}

// Fetch parents from DB
try {
    if (!empty($search)) {
        $stmt = $conn->prepare("SELECT * FROM parents 
                                WHERE first_name LIKE :search 
                                OR last_name LIKE :search 
                                OR email LIKE :search 
                                OR phone LIKE :search 
                                OR address LIKE :search 
                                ORDER BY parent_id ASC");
        $stmt->execute(['search' => "%$search%"]);
    } else {
        $stmt = $conn->prepare("SELECT * FROM parents ORDER BY parent_id ASC");
        $stmt->execute();
    }
    $parents = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>View Parents - NewSchool</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdn.datatables.net/1.10.24/css/dataTables.bootstrap5.min.css">
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/5.0.0/css/bootstrap.min.css">
  <link rel="stylesheet" href="../css/styles.css">
</head>
<body>

  <!-- Navbar -->
  <?php include('../include/navbar_main.php'); ?>

  <div class="container my-5">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <h2 class="text-primary"><i class="bi bi-people-fill"></i> Parents List</h2>
      <a href="parent_register.php" class="btn btn-primary">
        <i class="bi bi-plus-circle-fill"></i> Add Parent
      </a>
    </div>

    <!-- Search Bar 
    <form method="GET" class="mb-4">
      <div class="input-group">
        <input type="text" name="search" class="form-control" placeholder="Search by name, email, or phone" value="<?= htmlspecialchars($search) ?>">
        <button class="btn btn-outline-primary" type="submit"><i class="bi bi-search"></i> Search</button>
        <?php if (!empty($search)): ?>
          <a href="parent_view.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</a>
        <?php endif; ?>
      </div>
      -->
      
    </form>

    <!-- Feedback Messages -->
    <?php if (isset($_SESSION['success'])): ?>
      <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
      <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <!-- Parent Table -->
    <div class="card shadow-sm">
      <div class="card-body table-responsive">
        <table class="table table-hover align-middle table-bordered table-striped" id="table">
          <thead class="table-active">
              <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Address</th>
                <th>Relationship</th>
                <th>Ward ID</th>
                <th>Actions</th>
              </tr>
            </thead>
            <tbody>
              <?php if (count($parents) > 0): ?>
                <?php foreach ($parents as $parent): ?>
                  <tr>
                    <td><?= $parent['parent_id']; ?></td>
                    <td><?= htmlspecialchars($parent['first_name']); ?></td>
                    <td><?= htmlspecialchars($parent['last_name']); ?></td>
                    <td><?= htmlspecialchars($parent['email']); ?></td>
                    <td><?= htmlspecialchars($parent['phone']); ?></td>
                    <td><?= htmlspecialchars($parent['address']); ?></td>
                    <td><?= htmlspecialchars($parent['relationship']); ?></td>
                    <td><?= htmlspecialchars($parent['student_id']); ?></td>
                    <td>
                    <a href="parent_edit.php?parent_id=<?= $parent['parent_id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                    <a  href="parent_delete.php?parent_id=<?= $parent['parent_id']; ?>" 
                        class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this parent?');"><i class="bi bi-trash"></i></a>
                  </td>

                  </tr>
                <?php endforeach; ?>
              <?php else: ?>
                <tr>
                  <td colspan="8" class="text-center text-muted">No parents found.</td>
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
