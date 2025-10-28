<?php
session_start();
include('../include/db_connect.php'); // Ensure $conn is defined

$search = $_GET['search'] ?? '';

try {
    // Build SQL query with optional search filter
    $sql = "SELECT a.assessment_id, a.student_id, a.teacher_id, 
                   a.class, a.session, a.term, a.subject,
                   a.first_assignment, a.second_assignment,
                   a.first_test, a.second_test, a.exam,
                   CONCAT(s.first_name, ' ', s.last_name) AS student_name,
                   t.full_name AS teacher_name
            FROM assessments a
            JOIN students s ON a.student_id = s.student_id
            JOIN teachers t ON a.teacher_id = t.teacher_id";

    if (!empty($search)) {
        $sql .= " WHERE 
                    s.first_name LIKE :search OR 
                    s.last_name LIKE :search OR 
                    a.class LIKE :search OR 
                    a.subject LIKE :search OR 
                    a.session LIKE :search";
    }

    $sql .= " ORDER BY a.assessment_id ASC";

    $stmt = $conn->prepare($sql);
    if (!empty($search)) {
        $stmt->bindValue(':search', "%$search%");
    }
    $stmt->execute();
    $assessments = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}

// Function to calculate grade
function calculateGrade($total) {
    if ($total >= 80) return "A";
    if ($total >= 70) return "B";
    if ($total >= 60) return "C";
    if ($total >= 50) return "D";
    if ($total >= 40) return "E";
    return "F";
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Assessment Records - NewSchool</title>
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
  <div class="d-flex flex-wrap justify-content-between align-items-center mb-4 gap-2">
    <h2 class="text-primary mb-0"><i class="bi bi-people-fill"></i> Assessment Records</h2>
    <a href="assessment_add.php" class="btn btn-primary">
      <i class="bi bi-plus-circle-fill"></i> Add Assessment
    </a>
  </div>

  <!-- Search Form
  <form class="mb-4" method="GET" action="">
    <div class="input-group">
      <input type="text" name="search" value="<?= htmlspecialchars($search) ?>" class="form-control" placeholder="Search by student, class, subject, or session...">
      <button type="submit" class="btn btn-outline-primary"><i class="bi bi-search"></i> Search</button>
      <?php if (!empty($search)): ?>
        <a href="assessment_view.php" class="btn btn-outline-secondary"><i class="bi bi-x-circle"></i> Clear</a>
      <?php endif; ?>
    </div>
    -->

  </form>

  <div class="card shadow-sm border-0">
    <div class="card-body">

      <?php if (isset($_SESSION['success'])): ?>
        <div class="alert alert-success"><?= $_SESSION['success']; unset($_SESSION['success']); ?></div>
      <?php endif; ?>
      <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
      <?php endif; ?>

      <div class="table-responsive">
        <table class="table table-hover align-middle table-bordered table-striped" id="table">
          <thead class="table-active">
            <tr>
              <th>#</th>
              <th>Student</th>
              <th>Teacher</th>
              <th>Class</th>
              <th>Session</th>
              <th>Term</th>
              <th>Subject</th>
              <th>1st Assignment</th>
              <th>2nd Assignment</th>
              <th>1st Test</th>
              <th>2nd Test</th>
              <th>Exam</th>
              <th>Total</th>
              <th>Grade</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
            <?php if (count($assessments) > 0): ?>
              <?php foreach ($assessments as $row): 
                $total = $row['first_assignment'] + $row['second_assignment'] + $row['first_test'] + $row['second_test'] + $row['exam'];
                $grade = calculateGrade($total);
              ?>
                <tr>
                  <td><?= htmlspecialchars($row['assessment_id']); ?></td>
                  <td><?= htmlspecialchars($row['student_name']); ?></td>
                  <td><?= htmlspecialchars($row['teacher_name']); ?></td>
                  <td><?= htmlspecialchars($row['class']); ?></td>
                  <td><?= htmlspecialchars($row['session']); ?></td>
                  <td><?= htmlspecialchars($row['term']); ?></td>
                  <td><?= htmlspecialchars($row['subject']); ?></td>
                  <td><?= $row['first_assignment']; ?></td>
                  <td><?= $row['second_assignment']; ?></td>
                  <td><?= $row['first_test']; ?></td>
                  <td><?= $row['second_test']; ?></td>
                  <td><?= $row['exam']; ?></td>
                  <td><strong><?= $total; ?></strong></td>
                  <td><span class="badge bg-secondary"><?= $grade; ?></span></td>
                  <td>
                    <a href="assessment_edit.php?id=<?= $row['assessment_id']; ?>" class="btn btn-sm btn-primary"><i class="bi bi-pencil-square"></i></a>
                    <a href="assessment_delete.php?id=<?= $row['assessment_id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure you want to delete this assessment?');"><i class="bi bi-trash"></i></a>
                  </td>
                </tr>
              <?php endforeach; ?>
            <?php else: ?>
              <tr>
                <td colspan="15" class="text-center text-muted py-4">
                  <?php if ($search): ?>
                    No results found for "<strong><?= htmlspecialchars($search) ?></strong>".
                  <?php else: ?>
                    No assessments found.
                  <?php endif; ?>
                </td>
              </tr>
            <?php endif; ?>
          </tbody>
        </table>
      </div>

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
