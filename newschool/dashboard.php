<?php
session_start();

if (!isset($_SESSION['role'])) {
    header("Location: login.php");
    exit;
}

switch ($_SESSION['role']) {
    case 'admin':
        header("Location: admin/dashboard.php");
        break;
    case 'teacher':
        header("Location: teachers/dashboard.php");
        break;
    case 'parent':
        header("Location: parents/dashboard.php");
        break;
    case 'student':
        header("Location: students/dashboard.php");
        break;
    default:
        header("Location: login.php");
        break;
}
exit;
?>