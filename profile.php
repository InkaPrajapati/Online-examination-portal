<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

$student_id = $_SESSION['student_id'];

// Fetch student data
$sql = "SELECT name, email, enrollment, profile_image FROM students WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->bind_result($name, $email, $enrollment, $profile_image);
$stmt->fetch();
$stmt->close();

$img_path = ($profile_image && file_exists("../uploads/profile/$profile_image"))
            ? "../uploads/profile/$profile_image"
            : "../uploads/profile/default.png";

include("../includes/header.php");
?>

<div class="content-wrapper" style="max-width:700px; margin:auto; padding:20px;">
    <h2>My Profile</h2>

    <?php if (isset($_GET['updated'])): ?>
        <p style="color:green;">Profile updated successfully!</p>
    <?php endif; ?>

    <div style="text-align:center; margin-bottom:20px;">
        <img src="<?php echo $img_path; ?>" 
             style="width:120px; height:120px; border-radius:50%; object-fit:cover; border:3px solid #ddd;">
        <p><small>Click "Choose File" below to change picture</small></p>
    </div>

    <form method="POST" action="update_profile.php" enctype="multipart/form-data">

        <label>Name:</label>
        <input type="text" name="name" value="<?php echo htmlspecialchars($name); ?>" required
               style="width:100%; padding:10px; margin:10px 0;">

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required
               style="width:100%; padding:10px; margin:10px 0;">

        <label>Enrollment Number:</label>
        <input type="text" value="<?php echo htmlspecialchars($enrollment); ?>" readonly
               style="width:100%; padding:10px; margin:10px 0; background:#eee; cursor:not-allowed;">

        <label>New Password (leave empty to keep current):</label>
        <input type="password" name="password"
               style="width:100%; padding:10px; margin:10px 0;" placeholder="New password (optional)">

        <label>Profile Picture:</label>
        <input type="file" name="profile_image" accept="image/*"
               style="width:100%; padding:10px; margin:10px 0;">

        <button type="submit"
                style="padding:10px 20px; background:#007bff; color:white; border:none; border-radius:5px; cursor:pointer;">
            Update Profile
        </button>

    </form>
</div>

<?php include("../includes/footer.php"); ?>
