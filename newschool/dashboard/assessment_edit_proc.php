<?php
session_start();
include('../include/auth_check.php');
include('../include/db_connect.php'); // PDO connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $assessment_id = intval($_POST['assessment_id']);
    $subject = trim($_POST['subject']);
    $score = intval($_POST['score']);
    $term = trim($_POST['term']);
    $remarks = trim($_POST['remarks']);

    if (empty($subject) || empty($term)) {
        $_SESSION['error'] = "All required fields must be filled.";
        header("Location: assessment_edit.php?assessment_id=$assessment_id");
        exit;
    }

    try {
        $stmt = $conn->prepare("
            UPDATE assessments_tb
            SET subject = :subject,
                score = :score,
                term = :term,
                remarks = :remarks
            WHERE assessment_id = :assessment_id
        ");

        $stmt->bindParam(':subject', $subject);
        $stmt->bindParam(':score', $score, PDO::PARAM_INT);
        $stmt->bindParam(':term', $term);
        $stmt->bindParam(':remarks', $remarks);
        $stmt->bindParam(':assessment_id', $assessment_id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            $_SESSION['success'] = "Assessment updated successfully!";
        } else {
            $_SESSION['error'] = "Error updating assessment.";
        }

    } catch (PDOException $e) {
        $_SESSION['error'] = "Database error: " . $e->getMessage();
    }

    header("Location: assessment_edit.php?assessment_id=$assessment_id");
    exit;
} else {
    $_SESSION['error'] = "Invalid request.";
    header("Location: assessment_view.php");
    exit;
}
?>
