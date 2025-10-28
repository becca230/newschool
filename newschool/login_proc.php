<?php
session_start();
require_once "include/db_connect.php";

// Sanitize inputs
$username = trim($_POST['username'] ?? '');
$password = trim($_POST['password'] ?? '');

if (empty($username) || empty($password)) {
    $_SESSION['error'] = "Please fill in all fields.";
    header("Location: login.php");
    exit;
}

try {
    // Prepare PDO statement
    $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username LIMIT 1");
    $stmt->bindParam(':username', $username);
    $stmt->execute();

    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        // Start session
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['role'] = $user['role'];

        // Redirect based on role
        switch ($user['role']) {
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
    } else {
        $_SESSION['error'] = "Invalid username or password.";
        header("Location: login.php");
        exit;
    }
} catch (PDOException $e) {
    die("Database error: " . $e->getMessage());
}
