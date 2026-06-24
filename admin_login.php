<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header("Location: ../admin/dashboard.php");
    exit();
}

include("../includes/header.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Admin Login</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Admin Login</h2>

    <form action="admin_login_process.php" method="POST">
        <label>Email:</label>
        <input type="text" name="email" required placeholder="Enter Admin Email">

        <label>Password:</label>
        <input type="password" name="password" required placeholder="Enter Password">

        <button type="submit" class="login-btn">Login</button>
    </form>

    <p style="margin-top:10px;">Don't have an account? 
        <a href="admin_register.php">Register</a>
    </p>

</div>

</body>
</html>
<?php include("../includes/footer.php"); ?>
