<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php'); // Ensure $conn is your PDO connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // --- SANITIZATION ---
    $first_name    = htmlspecialchars(trim($_POST['first_name']));
    $last_name    = htmlspecialchars(trim($_POST['last_name']));
    $email        = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone        = htmlspecialchars(trim($_POST['phone']));
    $address      = htmlspecialchars(trim($_POST['address']));
    $relationship = htmlspecialchars(trim($_POST['relationship']));
    $student_id   = intval($_POST['student_id']);

    // --- VALIDATION ---
    if (
        empty($first_name) || empty($last_name) || empty($email) ||
        empty($phone) || empty($address) || empty($relationship) || empty($student_id)
    ) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: parent_register.php");
        exit;
    }

    // Full name validation
    if (!preg_match("/^[a-zA-Z\s.'-]+$/", $first_name) || !preg_match("/^[a-zA-Z\s.'-]+$/", $last_name)) {
        $_SESSION['error'] = "Names can only contain letters, spaces, dots, apostrophes, and hyphens.";
        header("Location: parent_register.php");
        exit;
    }

    // Email validation
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Invalid email format.";
        header("Location: parent_register.php");
        exit;
    }

    // Phone validation (Nigerian + optional international)
    if (!preg_match("/^(\+?\d{10,15})$/", $phone)) {
        $_SESSION['error'] = "Invalid phone number format.";
        header("Location: parent_register.php");
        exit;
    }

    // Relationship validation
    $allowed_relationships = ['Father', 'Mother', 'Guardian'];
    if (!in_array($relationship, $allowed_relationships)) {
        $_SESSION['error'] = "Invalid relationship selected.";
        header("Location: parent_register.php");
        exit;
    }

    // Check if student exists
    $stmt = $conn->prepare("SELECT student_id FROM students WHERE student_id = :student_id LIMIT 1");
    $stmt->bindParam(':student_id', $student_id, PDO::PARAM_INT);
    $stmt->execute();
    if ($stmt->rowCount() === 0) {
        $_SESSION['error'] = "Selected student does not exist.";
        header("Location: parent_register.php");
        exit;
    }

    try {
        // Check if parent already exists with same email
        $stmt = $conn->prepare("SELECT parent_id FROM parents WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "A parent with this email already exists.";
            header("Location: parent_register.php");
            exit;
        }

        // Insert new parent record
        $stmt = $conn->prepare("
            INSERT INTO parents (first_name, last_name, email, phone, address, relationship, student_id)
            VALUES (:first_name, :last_name, :email, :phone, :address, :relationship, :student_id)
        ");
        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':relationship', $relationship);
        $stmt->bindParam(':student_id', $student_id);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Parent registered successfully!";
        } else {
            $_SESSION['error'] = "Failed to register parent. Please try again.";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header("Location: parent_register.php");
    exit;
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: parent_register.php");
    exit;
}
?>
