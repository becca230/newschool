<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

if (isset($_GET['teacher_id'])) {
    $teacher_id = $_GET['teacher_id'];

    try {
        $stmt = $conn->prepare("DELETE FROM teachers WHERE teacher_id = ?");
        $stmt->execute([$teacher_id]);

        $_SESSION['success'] = "Teacher deleted successfully.";
    } catch (PDOException $e) {
        $_SESSION['error'] = "Error deleting teacher: " . $e->getMessage();
    }
} else {
    $_SESSION['error'] = "No teacher selected.";
}

header("Location: teacher_view.php");
exit;
