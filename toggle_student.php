<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

$id = $_GET['id'];
$status = $_GET['status'];

$query = "UPDATE students SET status = '$status' WHERE id = '$id'";
mysqli_query($conn, $query);

header("Location: manage_students.php");
exit();
?>