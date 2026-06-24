<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

if (isset($_GET['id'])) {
    $id = intval($_GET['id']);

    $stmt = $conn->prepare("DELETE FROM students WHERE id = ?");
    $stmt->bind_param("i", $id);
    $stmt->execute();

    if ($stmt->affected_rows > 0) {
        echo "<script>alert('Student deleted successfully'); window.location.href='manage_students.php';</script>";
    } else {
        echo "<script>alert('Failed to delete student (ID not found)'); window.location.href='manage_students.php';</script>";
    }

    $stmt->close();
} else {
    header("Location: manage_students.php");
    exit();
}
?>
