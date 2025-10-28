<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php'); // Ensure $conn is defined

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // 🧼 Sanitize inputs
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $subject   = htmlspecialchars(trim($_POST['subject']));
    $email     = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone     = htmlspecialchars(trim($_POST['phone']));
    $address   = htmlspecialchars(trim($_POST['address']));

    // ⚙️ Validate fields
    if (empty($full_name) || empty($subject) || empty($email) || empty($phone) || empty($address)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: teacher_register.php");
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error'] = "Please enter a valid email address.";
        header("Location: teacher_register.php");
        exit;
    }

    // Validate phone number (basic check)
    if (!preg_match('/^\+?\d{10,15}$/', $phone)) {
        $_SESSION['error'] = "Enter a valid phone number (10–15 digits).";
        header("Location: teacher_register.php");
        exit;
    }

    // Validate full name (only letters, spaces, and basic punctuation)
    if (!preg_match('/^[a-zA-Z\s\.\'-]+$/', $full_name)) {
        $_SESSION['error'] = "Full name can only contain letters and spaces.";
        header("Location: teacher_register.php");
        exit;
    }

    try {
        // Check for duplicate email
        $stmt = $conn->prepare("SELECT teacher_id FROM teachers WHERE email = :email LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "A teacher with this email already exists.";
            header("Location: teacher_register.php");
            exit;
        }

        // Insert data into DB
        $stmt = $conn->prepare("
            INSERT INTO teachers (full_name, subject, email, phone, address)
            VALUES (:full_name, :subject, :email, :phone, :address)
        ");
        $stmt->bindParam(':full_name', $full_name);
        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Teacher registered successfully!";
        } else {
            $_SESSION['error'] = "Something went wrong. Please try again.";
        }
        header("Location: teacher_register.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: teacher_register.php");
        exit;
    }
} else {
    header("Location: teacher_register.php");
    exit;
}
