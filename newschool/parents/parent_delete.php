<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

if (!isset($_GET['parent_id'])) {
    $_SESSION['error'] = "No parent ID provided.";
    header("Location: parent_view.php");
    exit;
}

$parent_id = intval($_GET['parent_id']);

try {
    // Delete parent
    $stmt = $conn->prepare("DELETE FROM parents WHERE parent_id = :parent_id");
    $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

    if ($stmt->execute()) {
        $_SESSION['success'] = "Parent deleted successfully!";
    } else {
        $_SESSION['error'] = "Failed to delete parent.";
    }
    header("Location: parent_view.php");
    exit;

} catch (PDOException $e) {
    $_SESSION['error'] = "Database error: " . $e->getMessage();
    header("Location: parent_view.php");
    exit;
}
