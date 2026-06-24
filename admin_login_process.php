<?php
session_start();
require_once("../config/db.php");

$email = $_POST['email'];
$password = md5($_POST['password']);

$stmt = $conn->prepare("SELECT id, admin_name FROM admins WHERE admin_email = ? AND admin_password = ?");
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("ss", $email, $password);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 1) {
    $stmt->bind_result($id, $name);
    $stmt->fetch();

    $_SESSION['admin_id'] = $id;
    $_SESSION['admin_name'] = $name;

    header("Location: dashboard.php");
    exit();
}

echo "<script>alert('Invalid Admin Credentials'); window.location.href='../admin_login.php';</script>";
exit();
?>
