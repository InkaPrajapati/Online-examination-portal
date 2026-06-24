<?php 
session_start();
if (isset($_SESSION['student_id'])) {
    header("Location: ../student/dashboard.php");
    exit();
}

include("../includes/header.php"); 

?>

<link rel="stylesheet" href="/online-exam-portal/assets/css/style.css">

<div class="register-container">

    <h2>Student Registration</h2>
    <p>Create your student account</p>

    <form class="reg-form" action="process/student_register_process.php" method="POST">

        <label>Full Name</label>
        <input type="text" name="name" required>

        <label>Email</label>
        <input type="email" name="email" required>

        <label>Enrollment No</label>
        <input type="text" name="enroll" required>

        <label>Password</label>
        <input type="password" name="password" required>

        <button type="submit" class="reg-btn">Register as Student</button>
    </form>

    <p style="margin-top: 15px; text-align: center;">
        Already have an account?
        <a href="student_login.php" style="color:#1e56d8; font-weight:bold;">Login</a>
    </p>

</div>

<?php include("../includes/footer.php"); ?>
