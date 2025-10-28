<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Get current page name for active link highlighting
$current_page = basename($_SERVER['PHP_SELF']);
?>

<!-- ✅ Add this at the top (before the <nav>) -->
<link rel="stylesheet" href="../assets/css/theme.css">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.css" rel="stylesheet">
  <link rel="stylesheet" href="../css/styles.css">

<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand fw-bold" href="#">NewSchool</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">

        <!-- 🏠 Common for all roles -->
        <li class="nav-item">
          <a class="nav-link <?= $current_page == 'dashboard.php' ? 'active' : '' ?>" href="../dashboard.php">
            <i class="bi bi-speedometer2"></i> Dashboard
          </a>
        </li>

        <!-- 👑 Admin Links -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'admin'): ?>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'manage_users.php' ? 'active' : '' ?>" href="../admin/manage_users.php">
              <i class="bi bi-people-fill"></i> Manage Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'student_view.php' ? 'active' : '' ?>" href="../students/student_view.php">
              <i class="bi bi-person-lines-fill"></i> Students
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'teacher_view.php' ? 'active' : '' ?>" href="../teachers/teacher_view.php">
              <i class="bi bi-person-workspace"></i> Teachers
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'parent_view.php' ? 'active' : '' ?>" href="../parents/parent_view.php">
              <i class="bi bi-people"></i> Parents
            </a>
          </li>
        <?php endif; ?>

        <!-- 👨‍🏫 Teacher Links -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'teacher'): ?>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'my_students.php' ? 'active' : '' ?>" href="../teachers/my_students.php">
              <i class="bi bi-person-lines-fill"></i> My Students
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'assignments.php' ? 'active' : '' ?>" href="../teachers/assignments.php">
              <i class="bi bi-journal-text"></i> Assignments
            </a>
          </li>
        <?php endif; ?>

        <!-- 👩‍👧 Parent Links -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'parent'): ?>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'child_info.php' ? 'active' : '' ?>" href="../parents/child_info.php">
              <i class="bi bi-person-hearts"></i> My Child
            </a>
          </li>
        <?php endif; ?>

        <!-- 🎓 Student Links -->
        <?php if (isset($_SESSION['role']) && $_SESSION['role'] === 'student'): ?>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'results.php' ? 'active' : '' ?>" href="../students/results.php">
              <i class="bi bi-bar-chart-line"></i> My Results
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link <?= $current_page == 'schedule.php' ? 'active' : '' ?>" href="../students/schedule.php">
              <i class="bi bi-journal-text"></i> My Schedule
            </a>
          </li>
        <?php endif; ?>

      </ul>

      <!-- 🔐 User dropdown -->
      <ul class="navbar-nav ms-auto">
        <?php if (isset($_SESSION['username'])): ?>
          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">
              <i class="bi bi-person-circle"></i>
              <?= htmlspecialchars($_SESSION['username']); ?> (<?= ucfirst($_SESSION['role']); ?>)
            </a>
            <ul class="dropdown-menu dropdown-menu-end">
              <li><a class="dropdown-item" href="profile.php"><i class="bi bi-person"></i> Profile</a></li>
              <li><hr class="dropdown-divider"></li>
              <li><a class="dropdown-item text-danger" href="../logout.php"><i class="bi bi-box-arrow-right"></i> Logout</a></li>
            </ul>
          </li>
        <?php else: ?>
          <li class="nav-item"><a class="nav-link" href="../login.php">Login</a></li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>
