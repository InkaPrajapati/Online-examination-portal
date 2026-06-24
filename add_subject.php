<?php
session_start();
include("../config/db.php");
include("../includes/header.php");

// ===== SUBJECT ADD FUNCTION =====
if (isset($_POST['add_subject'])) {
    $subject_name = $_POST['subject_name'];

    $insert = mysqli_query($conn, "INSERT INTO subjects(subject_name) VALUES('$subject_name')");

    if ($insert) {
        $message = "Subject Added Successfully!";
    } else {
        $message = "Error: " . mysqli_error($conn);
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Add Subject</title>
    <style>
        body { font-family: Arial; background: #f1f1f1; }
        .box { width: 400px; margin: 100px auto; padding: 20px; background: white; border-radius: 8px; }
        input { width: 100%; padding: 10px; margin-bottom: 10px; }
        button { padding: 10px 15px; }
        .msg { text-align: center; color: green; font-weight: bold; }
    </style>
</head>
<body>

<div class="box">
    <h2>Add New Subject</h2>

    <?php if (!empty($message)) echo "<p class='msg'>$message</p>"; ?>

    <form method="POST">
        <label>Subject Name:</label>
        <input type="text" name="subject_name" required>

        <button type="submit" name="add_subject">Add Subject</button>
    </form>
</div>

</body>
</html>
