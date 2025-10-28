<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['username']) || !isset($_SESSION['role'])) {
    header("Location: ../login.php");
    exit;
}

// Role-based access control
$current_dir = basename(dirname($_SERVER['PHP_SELF']));

if (
    ($current_dir === 'admin' && $_SESSION['role'] !== 'admin') ||
    ($current_dir === 'teacher' && $_SESSION['role'] !== 'teacher') ||
    ($current_dir === 'parent' && $_SESSION['role'] !== 'parent') ||
    ($current_dir === 'student' && $_SESSION['role'] !== 'student')
) {
    header("Location: ../unauthorized.php");
    exit;
}
