<?php 
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/dashboard.php");
    exit();
}

include("../includes/header.php"); 

?>

<link rel="stylesheet" href="/online-exam-portal/assets/css/style.css">

<div class="register-container">

    <h2>Admin Registration</h2>
    <p>Register with valid admin secret key</p>

    <form class="reg-form" action="process/admin_register_process.php" method="POST">

        <label>Admin Name</label>
        <input type="text" name="admin_name" required>

        <label>Email</label>
        <input type="email" name="admin_email" required>

        <label>Secret Key (Admin Code)</label>
        <input type="password" name="admin_key" required>

        <label>Password</label>
        <input type="password" name="admin_password" required>

        <button type="submit" class="reg-btn">Register as Admin</button>
    </form>

    <p style="margin-top: 15px; text-align: center;">
        Already have an account?
        <a href="admin_login.php" style="color:#1e56d8; font-weight:bold;">Login</a>
    </p>

</div>

<?php include("../includes/footer.php"); ?>
