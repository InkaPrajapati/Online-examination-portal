<?php
require "../config/db.php";

if (!isset($_GET['exam_id']) || !isset($_GET['student_id'])) {
    die("Invalid request");
}

$exam_id = intval($_GET['exam_id']);
$student_id = intval($_GET['student_id']);

$sql = "DELETE FROM results WHERE exam_id = ? AND student_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("ii", $exam_id, $student_id);

if ($stmt->execute()) {
    header("Location: manage_results.php?reset=success");
} else {
    echo "Failed to reset attempt.";
}
?>
