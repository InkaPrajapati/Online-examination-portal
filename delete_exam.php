<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../admin/admin_login.php");
    exit();
}

require_once("../config/db.php");

if (!isset($_GET['exam_id'])) {
    header("Location: exams_list.php");
    exit();
}

$exam_id = intval($_GET['exam_id']);

$stmt = $conn->prepare("DELETE FROM exams WHERE exam_id = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $exam_id);
$stmt->execute();

if ($stmt->affected_rows > 0) {
    echo "<script>alert('Exam deleted successfully'); window.location.href='exams_list.php';</script>";
} else {
    echo "<script>alert('Exam not found or could not be deleted'); window.location.href='exams_list.php';</script>";
}

$stmt->close();
?>
