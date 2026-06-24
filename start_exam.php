<?php
session_start();

// If student not logged in → redirect
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

// Fetch all exams
$exams = $conn->query("SELECT exam_id, title, total_marks, time_limit, exam_date FROM exams ORDER BY exam_date ASC");

?>
<div class="content-wrapper">
    <div class="create-exam-container" style="max-width:700px;">

        <h2>Available Exams</h2>
        <p>Select an exam to begin.</p>

        <?php if ($exams->num_rows > 0): ?>

            <table border="1" cellpadding="10" cellspacing="0" width="100%" style="border-collapse: collapse; text-align:center;">
                <tr style="background:#1e56d8; color:white;">
                    <th>Exam Title</th>
                    <th>Total Marks</th>
                    <th>Time (min)</th>
                    <th>Date</th>
                    <th>Action</th>
                </tr>

                <?php while($row = $exams->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['title']; ?></td>
                        <td><?php echo $row['total_marks']; ?></td>
                        <td><?php echo $row['time_limit']; ?></td>
                        <td><?php echo $row['exam_date']; ?></td>

                        <td>
                            <a href="take_exam.php?exam_id=<?php echo $row['exam_id']; ?>" 
                               style="background:#1e56d8; padding:6px 12px; color:white; text-decoration:none; border-radius:4px;">
                                Start
                            </a>
                        </td>
                    </tr>
                <?php endwhile; ?>

            </table>

        <?php else: ?>
            <p>No exams available right now.</p>
        <?php endif; ?>

    </div>
</div>

<?php include("../includes/footer.php"); ?>
