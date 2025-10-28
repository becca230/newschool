<?php
session_start();
include('include/db_connect.php'); // Make sure this file sets $conn as PDO

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);

    // Validate input
    if (empty($username) || empty($password)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: login.php");
        exit;
    }

    try {
        // Check for username
        $stmt = $conn->prepare("SELECT id, username, password FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        // If user exists
        if ($stmt->rowCount() > 0) {
            $user = $stmt->fetch(PDO::FETCH_ASSOC);

            // Verify password
            if (password_verify($password, $user['password'])) {
                $_SESSION['user_id']  = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['success']  = "Welcome back, " . htmlspecialchars($user['username']) . "!";

                header("Location: dashboard/index.php");
                exit;
            } else {
                $_SESSION['error'] = "Incorrect password.";
                header("Location: login.php");
                exit;
            }
        } else {
            $_SESSION['error'] = "User not found.";
            header("Location: login.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: login.php");
        exit;
    }
} else {
    header("Location: login.php");
    exit;
}
?>


