<?php
session_start();

// Check admin login BEFORE any HTML output
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
?>

<div class="content-wrapper">
    <div class="create-exam-container">

        <h2>Create New Exam</h2>
        <p>Fill the form below to create a new exam for students.</p>

        <form action="save_exam.php" method="POST" class="create-exam-form">

            <label>Exam Title</label>
            <input type="text" name="exam_title" required>

            <label>Description</label>
            <textarea name="description"></textarea>

            <label>Total Marks</label>
            <input type="number" name="total_marks" required>

            <label>Time Limit (minutes)</label>
            <input type="number" name="time_limit" required>

            <label>Exam Date</label>
            <input type="date" name="exam_date" required>

            <input type="submit" value="Create Exam" class="create-exam-btn">
        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>
