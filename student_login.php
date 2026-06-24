<?php
session_start();

if (isset($_SESSION['student_id'])) {
    header("Location: ../student/dashboard.php");
    exit();
}
if ($row && password_verify($password, $row['password'])) {

    // 🔐 STATUS CHECK YAHAN LAGANA HAI
    if ($row['status'] == 0) {
        echo "<script>alert('Your account is disabled. Contact admin.'); window.location='student_login.php';</script>";
        exit();
    }

    // ✔ STATUS OK → Login allow
    $_SESSION['student_id'] = $row['id'];
    $_SESSION['student_name'] = $row['name'];
    $_SESSION['student_email'] = $row['email'];

    header("Location: ../student/dashboard.php");
    exit();
}

include("../includes/header.php");

?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Student Login</title>
<link rel="stylesheet" href="../assets/css/style.css">
</head>
<body>

<div class="login-container">
    <h2>Student Login</h2>

    <form action="process/student_login_process.php" method="POST">
        <label>Email:</label>
        <input type="text" name="email" required placeholder="Enter Email">

        <label>Password:</label>
        <input type="password" name="password" required placeholder="Enter Password">

        <button type="submit" class="login-btn">Login</button>
    </form>

    <p style="margin-top:10px;">Don't have an account? 

    </p>

</div>

</body>
</html>
<?php include("../includes/footer.php"); ?>
