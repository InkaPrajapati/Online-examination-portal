<?php
session_start();
ob_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title       = trim($_POST['exam_title']);
    $description = trim($_POST['description']);
    $total_marks = trim($_POST['total_marks']);
    $time_limit  = trim($_POST['time_limit']);
    $exam_date   = trim($_POST['exam_date']);

    // Validate required fields
    if (empty($title) || empty($total_marks) || empty($time_limit) || empty($exam_date)) {
        echo "<script>
                alert('All required fields must be filled.');
                window.history.back();
              </script>";
        exit();
    }

    // Prepare SQL
    $stmt = $conn->prepare("
    INSERT INTO exams (title, description, total_marks, time_limit, exam_date)
    VALUES (?, ?, ?, ?, ?)
");

if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ssiss", $title, $description, $total_marks, $time_limit, $exam_date);


    if ($stmt->execute()) {
        echo "<script>
                alert('Exam created successfully!');
                window.location.href = 'add_questions.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error: Could not save exam.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
