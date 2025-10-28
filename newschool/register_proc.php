<?php
session_start();
include('include/db_connect.php'); // Ensure $conn is your PDO connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // ✅ CAPTCHA VALIDATION
    if (!isset($_POST['captcha_answer'], $_POST['captcha_sum']) || 
        $_POST['captcha_answer'] != $_POST['captcha_sum']) {
        $_SESSION['error'] = "Incorrect answer to the security question. Please try again.";
        header("Location: register.php");
        exit;
    }

    // ✅ SANITIZE FUNCTION
    function cleanInput($data) {
        $data = trim($data);
        $data = stripslashes($data);
        $data = htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
        return $data;
    }

    // ✅ SANITIZE & VALIDATE USER INPUTS
    $first_name = cleanInput($_POST['first_name'] ?? '');
    $last_name  = cleanInput($_POST['last_name'] ?? '');
    $username   = cleanInput($_POST['username'] ?? '');
    $password   = $_POST['password'] ?? ''; // don't sanitize password
    $role       = cleanInput($_POST['role'] ?? '');
    $security_question = cleanInput($_POST['security_question'] ?? '');
    $security_answer   = cleanInput($_POST['security_answer'] ?? '');

    // ✅ REQUIRED FIELD CHECK
    if (
        empty($first_name) || empty($last_name) || empty($username) ||
        empty($password) || empty($role) || 
        empty($security_question) || empty($security_answer)
    ) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: register.php");
        exit;
    }

    // ✅ USERNAME VALIDATION
    if (!preg_match("/^[a-zA-Z0-9_]{4,20}$/", $username)) {
        $_SESSION['error'] = "Username must be 4–20 characters long and contain only letters, numbers, or underscores.";
        header("Location: register.php");
        exit;
    }

    // ✅ PASSWORD VALIDATION
    if (strlen($password) < 6) {
        $_SESSION['error'] = "Password must be at least 6 characters long.";
        header("Location: register.php");
        exit;
    }

    // ✅ HASH PASSWORD
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    try {
        // ✅ Check for existing username
        $stmt = $conn->prepare("SELECT id FROM users WHERE username = :username LIMIT 1");
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Username already exists!";
            header("Location: register.php");
            exit;
        }

        // ✅ Insert new user safely
        $stmt = $conn->prepare("
            INSERT INTO users 
            (first_name, last_name, username, password, role, security_question, security_answer) 
            VALUES 
            (:first_name, :last_name, :username, :password, :role, :security_question, :security_answer)
        ");

        $stmt->bindParam(':first_name', $first_name, PDO::PARAM_STR);
        $stmt->bindParam(':last_name', $last_name, PDO::PARAM_STR);
        $stmt->bindParam(':username', $username, PDO::PARAM_STR);
        $stmt->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindParam(':role', $role, PDO::PARAM_STR);
        $stmt->bindParam(':security_question', $security_question, PDO::PARAM_STR);
        $stmt->bindParam(':security_answer', $security_answer, PDO::PARAM_STR);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Registration successful! You can now log in.";
            header("Location: login.php");
            exit;
        } else {
            $_SESSION['error'] = "Registration failed. Please try again.";
            header("Location: register.php");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . htmlspecialchars($e->getMessage());
        header("Location: register.php");
        exit;
    }

} else {
    header("Location: register.php");
    exit;
}
