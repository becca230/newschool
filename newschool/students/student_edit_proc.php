<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $student_id    = intval($_POST['student_id']);
    $first_name    = htmlspecialchars(trim($_POST['first_name'] ?? ''), ENT_QUOTES);
    $last_name     = htmlspecialchars(trim($_POST['last_name'] ?? ''), ENT_QUOTES);
    $class         = htmlspecialchars(trim($_POST['class'] ?? ''), ENT_QUOTES);
    $gender        = htmlspecialchars(trim($_POST['gender'] ?? ''), ENT_QUOTES);
    $date_of_birth = htmlspecialchars(trim($_POST['date_of_birth'] ?? ''), ENT_QUOTES);
    $parent_phone  = preg_replace('/[^0-9+]/', '', $_POST['parent_phone'] ?? '');
    $photo_name    = null;

    // ✅ Basic Validation
    if (empty($first_name) || empty($last_name) || empty($class) || empty($gender) || empty($date_of_birth) || empty($parent_phone)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: student_edit.php?student_id=$student_id");
        exit;
    }

    if (!preg_match('/^\+?\d{10,15}$/', $parent_phone)) {
        $_SESSION['error'] = "Invalid phone number format.";
        header("Location: student_edit.php?student_id=$student_id");
        exit;
    }

    if (!strtotime($date_of_birth) || strtotime($date_of_birth) > time()) {
        $_SESSION['error'] = "Invalid date of birth.";
        header("Location: student_edit.php?student_id=$student_id");
        exit;
    }

    try {
        // Fetch current student record
        $stmt = $conn->prepare("SELECT photo FROM students WHERE student_id = :id");
        $stmt->execute([':id' => $student_id]);
        $student = $stmt->fetch(PDO::FETCH_ASSOC);

        // Handle photo upload if new file provided
        if (isset($_FILES['photo']) && $_FILES['photo']['error'] === UPLOAD_ERR_OK) {
            $upload_dir = "../uploads/students/";
            if (!is_dir($upload_dir)) mkdir($upload_dir, 0777, true);

            $file_tmp = $_FILES['photo']['tmp_name'];
            $file_ext = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
            $allowed_exts = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

            if (!in_array($file_ext, $allowed_exts)) {
                $_SESSION['error'] = "Invalid image format. Use JPG, PNG, GIF, or WEBP.";
                header("Location: student_edit.php?student_id=$student_id");
                exit;
            }

            if ($_FILES['photo']['size'] > 2 * 1024 * 1024) {
                $_SESSION['error'] = "Image file too large. Max 2MB.";
                header("Location: student_edit.php?student_id=$student_id");
                exit;
            }

            $new_name = uniqid("student_", true) . "." . $file_ext;
            $photo_path = $upload_dir . $new_name;

            if (move_uploaded_file($file_tmp, $photo_path)) {
                $photo_name = $new_name;
                // Delete old photo if exists
                if (!empty($student['photo']) && file_exists($upload_dir . $student['photo'])) {
                    unlink($upload_dir . $student['photo']);
                }
            } else {
                $_SESSION['error'] = "Failed to upload image.";
                header("Location: student_edit.php?student_id=$student_id");
                exit;
            }
        } else {
            $photo_name = $student['photo']; // keep old one
        }

        // Update record
        $stmt = $conn->prepare("UPDATE students 
            SET first_name = :first_name, 
                last_name = :last_name, 
                class = :class, 
                gender = :gender, 
                date_of_birth = :date_of_birth, 
                parent_phone = :parent_phone, 
                photo = :photo 
            WHERE student_id = :student_id");

        $stmt->execute([
            ':first_name'   => $first_name,
            ':last_name'    => $last_name,
            ':class'        => $class,
            ':gender'       => $gender,
            ':date_of_birth'=> $date_of_birth,
            ':parent_phone' => $parent_phone,
            ':photo'        => $photo_name,
            ':student_id'   => $student_id
        ]);

        $_SESSION['success'] = "Student record updated successfully!";
        header("Location: student_view.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: student_edit.php?student_id=$student_id");
        exit;
    }
} else {
    $_SESSION['error'] = "Invalid request method.";
    header("Location: student_view.php");
    exit;
}
?>
