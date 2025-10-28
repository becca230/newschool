<?php
include('../include/config.php');

if (isset($_POST['class'])) {
    $class = $_POST['class'];

    $stmt = $pdo->prepare("SELECT student_id, first_name, last_name FROM students WHERE class = ?");
    $stmt->execute([$class]);
    $students = $stmt->fetchAll(PDO::FETCH_ASSOC);

    if ($students) {
        foreach ($students as $student) {
            echo "<option value='{$student['student_id']}'>" . 
                 htmlspecialchars($student['first_name'] . " " . $student['last_name']) . 
                 "</option>";
        }
    } else {
        echo "<option value=''>No students available</option>";
    }
}
?>


<?php
include('../include/config.php');

$search = isset($_GET['q']) ? trim($_GET['q']) : '';

$sql = "SELECT student_id, first_name, last_name 
        FROM students 
        WHERE first_name LIKE :search OR last_name LIKE :search 
        ORDER BY first_name ASC LIMIT 20";

$stmt = $conn->prepare($sql);
$stmt->execute(['search' => "%$search%"]);

$results = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $results[] = [
        'id' => $row['student_id'],
        'text' => $row['first_name'] . ' ' . $row['last_name']
    ];
}

echo json_encode(['results' => $results]);
?>

