<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- SANITIZATION ---
    $teacher_id = intval($_POST['teacher_id']);
    $full_name  = htmlspecialchars(trim($_POST['full_name']));
    $subject    = htmlspecialchars(trim($_POST['subject']));
    $email      = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone      = htmlspecialchars(trim($_POST['phone']));
    $address    = htmlspecialchars(trim($_POST['address']));

    // --- VALIDATION ---
    if (empty($teacher_id) || empty($full_name) || empty($subject) || empty($email) || empty($phone) || empty($address)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
        exit;
    }

    // Name validation
    if (!preg_match("/^[a-zA-Z\s.'-]+$/", $full_name)) {
        $_SESSION['error'] = "Full name can only contain letters, spaces, dots, apostrophes, and hyphens.";
        header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
        exit;
    }

    // Phone validation
    if (!preg_match("/^(\+?\d{10,15})$/", $phone)) {
        $_SESSION['error'] = "Invalid phone number format.";
        header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
        exit;
    }

    // Subject validation
    $allowed_subjects = ['Mathematics', 'English', 'Science', 'Arts'];
    if (!in_array($subject, $allowed_subjects)) {
        $_SESSION['error'] = "Invalid subject selection.";
        header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
        exit;
    }

    try {
        // Check if email belongs to another teacher
        $stmt = $conn->prepare("SELECT teacher_id FROM teachers WHERE email = :email AND teacher_id != :id LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':id', $teacher_id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "This email is already used by another teacher.";
            header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
            exit;
        }

        // Update record
        $stmt = $conn->prepare("
            UPDATE teachers 
            SET full_name = :full_name, subject = :subject, email = :email, phone = :phone, address = :address
            WHERE teacher_id = :id
        ");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':id', $teacher_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Teacher updated successfully!";
        } else {
            $_SESSION['error'] = "Failed to update teacher. Please try again.";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header("Location: teacher_edit.php?teacher_id=" . $teacher_id);
    exit;

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: teacher_view.php");
    exit;
}
?>
