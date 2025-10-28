<?php
session_start();
include('../include/db_connect.php');

if (!isset($_SESSION['user_id'])) {
    header("Location: ../index.php");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $user_id = $_SESSION['user_id'];
    $old_password = $_POST['old_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    try {
        // Fetch current user password
        $stmt = $conn->prepare("SELECT password FROM users WHERE id = ?");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($old_password, $user['password'])) {
            if ($new_password === $confirm_password) {
                $hashed = password_hash($new_password, PASSWORD_DEFAULT);

                $update = $conn->prepare("UPDATE users SET password = ? WHERE id = ?");
                $update->execute([$hashed, $user_id]);

                $_SESSION['success'] = "Password changed successfully!";
            } else {
                $_SESSION['error'] = "New passwords do not match.";
            }
        } else {
            $_SESSION['error'] = "Password change failed.";
        }
    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }
}

header("Location: change_password.php");
exit();
?>
