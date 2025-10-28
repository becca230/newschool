<?php
session_start();
include('../include/db_connect.php');
include('../include/auth_check.php'); // optional: restrict access to logged-in users

if (!isset($_GET['student_id']) || empty($_GET['student_id'])) {
    $_SESSION['error'] = "Invalid student ID.";
    header("Location: student_view.php");
    exit;
}

$student_id = $_GET['student_id'];

try {
    // ✅ Fetch the current student’s photo before deleting
    $stmt = $conn->prepare("SELECT photo FROM students WHERE student_id = :id");
    $stmt->execute([':id' => $student_id]);
    $student = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$student) {
        $_SESSION['error'] = "Student not found.";
        header("Location: student_view.php");
        exit;
    }

    // ✅ Delete the student record
    $delete_stmt = $conn->prepare("DELETE FROM students WHERE student_id = :id");
    $delete_stmt->execute([':id' => $student_id]);

    // ✅ If delete succeeded, remove their photo (if it exists)
    if ($delete_stmt->rowCount() > 0 && !empty($student['photo'])) {
        $photo_path = "../uploads/students/" . $student['photo'];
        if (file_exists($photo_path)) {
            unlink($photo_path);
        }
    }

    $_SESSION['success'] = "Student deleted successfully.";
    header("Location: student_view.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: student_view.php");
    exit;
}
?>