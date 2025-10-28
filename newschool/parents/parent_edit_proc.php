<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $parent_id    = intval($_POST['parent_id']);
    $first_name    = trim($_POST['first_name']);
    $last_name    = trim($_POST['last_name']);
    $email        = trim($_POST['email']);
    $phone        = trim($_POST['phone']);
    $address      = trim($_POST['address']);
    $relationship = trim($_POST['relationship']);
    $student_id   = trim($_POST['student_id']);

    // Validation
    if (empty($parent_id) || empty($first_name) || empty($last_name) || empty($email) || empty($phone) || empty($address) || empty($relationship) || empty($student_id)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: parent_edit.php?parent_id=$parent_id");
        exit;
    }

    try {
        // Ensure email uniqueness (excluding current parent)
        $stmt = $conn->prepare("SELECT parent_id FROM parents WHERE email = :email AND parent_id != :parent_id LIMIT 1");
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            $_SESSION['error'] = "Another parent with this email already exists.";
            header("Location: parent_edit.php?parent_id=$parent_id");
            exit;
        }

        // Update parent record
        $stmt = $conn->prepare("UPDATE parents 
                                SET first_name = :first_name, 
                                    last_name = :last_name,
                                    email = :email, 
                                    phone = :phone, 
                                    address = :address, 
                                    relationship = :relationship, 
                                    student_id = :student_id
                                WHERE parent_id = :parent_id");

        $stmt->bindParam(':first_name', $first_name);
        $stmt->bindParam(':last_name', $last_name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':phone', $phone);
        $stmt->bindParam(':address', $address);
        $stmt->bindParam(':relationship', $relationship);
        $stmt->bindParam(':student_id', $student_id);
        $stmt->bindParam(':parent_id', $parent_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Parent updated successfully!";
            header("Location: parent_view.php");
            exit;
        } else {
            $_SESSION['error'] = "Failed to update parent.";
            header("Location: parent_edit.php?parent_id=$parent_id");
            exit;
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: parent_edit.php?parent_id=$parent_id");
        exit;
    }

} else {
    header("Location: parent_view.php");
    exit;
}
