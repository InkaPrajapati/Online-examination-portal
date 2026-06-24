<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

$name = trim($_POST['name']);
$email = trim($_POST['email']);
$new_password = trim($_POST['password']);

// ----- 1. Check duplicate email -----
$sql = "SELECT id FROM students WHERE email = ? AND id != ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("si", $email, $student_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    die("Email already in use. <a href='profile.php'>Go Back</a>");
}
$stmt->close();

// ----- 2. Handle profile image upload -----
$profile_image = null;

// Fetch old image
$sql = "SELECT profile_image FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($old_image);
$stmt->fetch();
$stmt->close();

if (!empty($_FILES['profile_image']['name'])) {

    $img = $_FILES['profile_image'];
    $ext = strtolower(pathinfo($img['name'], PATHINFO_EXTENSION));

    // Validate image type
    $allowed = array('jpg', 'jpeg', 'png', 'gif');
    if (!in_array($ext, $allowed)) {
        die("Invalid image type. <a href='profile.php'>Back</a>");
    }

    // File size limit (2MB)
    if ($img['size'] > 2 * 1024 * 1024) {
        die("Image too large. Max 2MB.<a href='profile.php'>Back</a>");
    }

    // Rename file
    $profile_image = "IMG_" . time() . "_" . rand(1000,9999) . "." . $ext;

    // Upload
    move_uploaded_file($img['tmp_name'], "../uploads/profile/" . $profile_image);

    // Delete old image if not default
    if ($old_image && file_exists("../uploads/profile/$old_image") && $old_image != "default.png") {
        unlink("../uploads/profile/$old_image");
    }

} else {
    // Keep old image
    $profile_image = $old_image;
}

// ----- 3. Update profile -----
if ($new_password !== "") {
    $hashed_password = md5($new_password, PASSWORD_DEFAULT);
    $sql = "UPDATE students SET name=?, email=?, password=?, profile_image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $name, $email, $hashed_password, $profile_image, $student_id);
} else {
    $sql = "UPDATE students SET name=?, email=?, profile_image=? WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $profile_image, $student_id);
}

$stmt->execute();
$stmt->close();

header("Location: profile.php?updated=1");
exit();
