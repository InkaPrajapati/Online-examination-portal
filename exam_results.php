<?php
session_start();

// Only admin allowed
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

$query = "
    SELECT 
        r.id AS result_id,
        s.name AS student_name,
        s.email AS student_email,
        e.title AS exam_title,
        r.score,
        e.total_marks,
        r.created_at
    FROM results r
    JOIN students s ON r.student_id = s.id
    JOIN exams e ON r.exam_id = e.exam_id
    ORDER BY r.id DESC
";

$result = $conn->query($query);
?>

<?php include("../includes/header.php"); ?>

<div class="content-wrapper" style="margin: 0 40px;">
    <h2>Exam Results</h2>
    <p>Below is the list of all exam results submitted by students.</p>
    <center>
    <table class="students-table">
        <tr>
            <th>ID</th>
            <th>Student</th>
            <th>Email</th>
            <th>Exam</th>
            <th>Score</th>
            <th>Total</th>
            <th>Date</th>
        </tr>

        <?php if ($result && $result->num_rows > 0): ?>
            <?php while($row = $result->fetch_assoc()): ?>
                <tr>
                    <td><?php echo $row['result_id']; ?></td>
                    <td><?php echo htmlspecialchars($row['student_name']); ?></td>
                    <td><?php echo htmlspecialchars($row['student_email']); ?></td>
                    <td><?php echo htmlspecialchars($row['exam_title']); ?></td>
                    <td><?php echo $row['score']; ?></td>
                    <td><?php echo $row['total_marks']; ?></td>
                    <td><?php echo $row['created_at']; ?></td>
                </tr>
            <?php endwhile; ?>
        <?php else: ?>
            <tr>
                <td colspan="9" style="text-align:center;">No results found</td>
            </tr>
        <?php endif; ?>

    </table>
    </center>
</div>


<?php include("../includes/footer.php"); ?>
