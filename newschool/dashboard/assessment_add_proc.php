<?php
session_start();
include('../include/db_connect.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $class             = trim($_POST['class']);
    $student_id        = trim($_POST['student_id']);
    $session_year      = trim($_POST['session']);
    $term              = trim($_POST['term']);
    $teacher_id        = trim($_POST['teacher_id']);
    $subject           = trim($_POST['subject']);
    $first_assignment  = (int) $_POST['first_assignment'];
    $second_assignment = (int) $_POST['second_assignment'];
    $first_test        = (int) $_POST['first_test'];
    $second_test       = (int) $_POST['second_test'];
    $exam              = (int) $_POST['exam'];

    // Validate required fields
    if (empty($class) || empty($student_id) || empty($session_year) || empty($term) || empty($subject) || empty($teacher_id)) {
    $_SESSION['error'] = "All fields are required.";
    header("Location: assessment_add.php");
    exit;
}


    try {
        // Optional: check if an assessment already exists for same student, session, term, subject
        $check = $conn->prepare("SELECT assessment_id FROM assessments 
                                 WHERE student_id = :student_id 
                                 AND session = :session 
                                 AND term = :term 
                                 AND subject = :subject 
                                 LIMIT 1");
        $check->execute([
            ':student_id' => $student_id,
            ':session'    => $session_year,
            ':term'       => $term,
            ':subject'    => $subject
        ]);

        if ($check->rowCount() > 0) {
            $_SESSION['error'] = "Assessment already exists for this student in the selected session, term, and subject.";
            header("Location: assessment_add.php");
            exit;
        }

        // Insert new assessment
        $stmt = $conn->prepare("INSERT INTO assessments 
    (class, student_id, teacher_id, session, term, subject, first_assignment, second_assignment, first_test, second_test, exam) 
    VALUES 
    (:class, :student_id, :teacher_id, :session, :term, :subject, :first_assignment, :second_assignment, :first_test, :second_test, :exam)");

$stmt->execute([
    ':class'             => $class,
    ':student_id'        => $student_id,
    ':teacher_id'        => $teacher_id,
    ':session'           => $session_year,
    ':term'              => $term,
    ':subject'           => $subject,
    ':first_assignment'  => $first_assignment,
    ':second_assignment' => $second_assignment,
    ':first_test'        => $first_test,
    ':second_test'       => $second_test,
    ':exam'              => $exam
]);


        $_SESSION['success'] = "Assessment added successfully!";
        header("Location: assessment_add.php");
        exit;

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
        header("Location: assessment_add.php");
        exit;
    }
} else {
    header("Location: assessment_add.php");
    exit;
}
