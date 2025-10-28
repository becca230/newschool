<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php');

$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize input
    $first_name   = htmlspecialchars(trim($_POST['first_name'] ?? ''), ENT_QUOTES);
    $last_name    = htmlspecialchars(trim($_POST['last_name'] ?? ''), ENT_QUOTES);
    $class        = htmlspecialchars(trim($_POST['class'] ?? ''), ENT_QUOTES);
    $gender       = htmlspecialchars(trim($_POST['gender'] ?? ''), ENT_QUOTES);
    $dob          = htmlspecialchars(trim($_POST['date_of_birth'] ?? ''), ENT_QUOTES);
    $parent_phone = preg_replace('/[^0-9+]/', '', $_POST['parent_phone'] ?? ''); // only digits & +
    $photoName    = '';

    // ✅ Basic Validation
    if (empty($first_name) || empty($last_name) || empty($class) || empty($gender) || empty($dob) || empty($parent_phone)) {
        $_SESSION['error'] = "All fields are required.";
        header("Location: student_register.php");
        exit;
    }

    if (!preg_match('/^\+?\d{10,15}$/', $parent_phone)) {
        $_SESSION['error'] = "Invalid phone number format.";
        header("Location: student_register.php");
        exit;
    }

    // Validate date of birth (must be a valid date and not in the future)
    if (!strtotime($dob) || strtotime($dob) > time()) {
        $_SESSION['error'] = "Please enter a valid date of birth.";
        header("Location: student_register.php");
        exit;
    }

    // ✅ Handle profile photo upload
    if (!empty($_FILES['photo']['name'])) {
        $targetDir = "../uploads/students/";
        if (!file_exists($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileExt   = strtolower(pathinfo($_FILES['photo']['name'], PATHINFO_EXTENSION));
        $allowedExt = ['jpg', 'jpeg', 'png', 'gif', 'webp'];

        if (!in_array($fileExt, $allowedExt)) {
            $_SESSION['error'] = "Invalid image format. Use JPG, PNG, GIF, or WEBP.";
            header("Location: student_register.php");
            exit;
        }

        if ($_FILES['photo']['size'] > 2 * 1024 * 1024) { // 2MB limit
            $_SESSION['error'] = "Image file too large. Max 2MB.";
            header("Location: student_register.php");
            exit;
        }

        $photoName = uniqid("student_", true) . "." . $fileExt;
        $targetFilePath = $targetDir . $photoName;

        if (!move_uploaded_file($_FILES['photo']['tmp_name'], $targetFilePath)) {
            $_SESSION['error'] = "Failed to upload student photo.";
            header("Location: student_register.php");
            exit;
        }
    }

    try {
        // ✅ Step 1: Get current year
        $year = date('Y');

        // ✅ Step 2: Fetch last registration number for this year
        $stmt = $conn->prepare("SELECT registration_no FROM students 
                                WHERE registration_no LIKE :yearPattern
                                ORDER BY student_id DESC LIMIT 1");
        $stmt->execute(['yearPattern' => "%/$year/%"]);
        $lastStudent = $stmt->fetch(PDO::FETCH_ASSOC);

        $newNumber = 1;
        if ($lastStudent && preg_match('/(\d{3})$/', $lastStudent['registration_no'], $matches)) {
            $newNumber = intval($matches[1]) + 1;
        }

        // ✅ Step 3: Generate registration number
        $regNo = sprintf("NWS/%s/%03d", $year, $newNumber);

        // ✅ Step 4: Insert into database
        $stmt = $conn->prepare("INSERT INTO students 
            (first_name, last_name, class, gender, date_of_birth, parent_phone, photo, registration_no)
            VALUES (:first_name, :last_name, :class, :gender, :dob, :parent_phone, :photo, :regNo)");

        $stmt->execute([
            ':first_name'   => $first_name,
            ':last_name'    => $last_name,
            ':class'        => $class,
            ':gender'       => $gender,
            ':dob'          => $dob,
            ':parent_phone' => $parent_phone,
            ':photo'        => $photoName,
            ':regNo'        => $regNo
        ]);

        $_SESSION['success'] = "Student registered successfully with ID: $regNo";
        header("Location: student_view.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: student_register.php");
        exit;
    }

} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: student_register.php");
    exit;
}
?>
