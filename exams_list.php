<?php
session_start();

// Require admin login
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}

require_once "../config/db.php";
include("../includes/header.php");
?>

<style>
.create-exam-container {
    max-width: 600px;
    margin: 40px auto 60px auto;
    background: white;
    padding: 30px 35px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.create-exam-btn {
    text-decoration: none;
    color: #fff;
    border-radius: 5px;
}
.btn-simple-blue {
    background-color: #2563EB;  /* Bright blue */
    color: white;
    padding: 8px 20px;
    font-size: 16px;
    border: none;
    border-radius: 6px;
    text-decoration: none;
    display: inline-block;
    cursor: pointer;
    transition: background-color 0.3s ease;
    font-weight: 500;
}

.btn-simple-blue:hover {
    background-color: #1E40AF;  /* Darker blue on hover */
}

</style>

<div class="content-wrapper">
    <div class="create-exam-container" style="max-width:1000px;">
        <div style="display:flex; justify-content:space-between; align-items:center;">
            <h2>Exams</h2>
            <a href="create_exam.php" class="btn-simple-blue">Create New Exam</a>
        </div>

<?php
// Check database connection
if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

// Prepare SQL query
$sql = "SELECT exam_id, title, total_marks, time_limit, exam_date FROM exams ORDER BY exam_date DESC";
$stmt = $conn->prepare($sql);

// Check if prepare() succeeded
if (!$stmt) {
    die("SQL prepare failed: " . $conn->error);
}

// Execute the statement
if (!$stmt->execute()) {
    die("SQL execute failed: " . $stmt->error);
}

// Store result and bind columns
$stmt->store_result();
$stmt->bind_result($exam_id, $title, $total_marks, $time_limit, $exam_date);

$exams = array();
while ($stmt->fetch()) {
    $exams[] = array(
        'exam_id' => $exam_id,
        'title' => $title,
        'total_marks' => $total_marks,
        'time_limit' => $time_limit,
        'exam_date' => $exam_date
    );
}
$stmt->close();
?>

<?php if (!empty($exams)): ?>
    <table style="width:100%; border-collapse:collapse; margin-top:20px;">
        <thead>
            <tr style="background:#1e56d8; color:#fff;">
                <th style="padding:8px; width:30%;">Title</th>
                <th style="padding:8px; width:10%; text-align:center;">Marks</th>
                <th style="padding:8px; width:10%; text-align:center;">Time</th>
                <th style="padding:8px; width:15%; text-align:center;">Date</th>
                <th style="padding:8px; width:35%; text-align:center;">Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($exams as $exam): ?>
                <tr style="border-bottom:1px solid #eee;">
                    <td style="padding:8px;"><?php echo htmlspecialchars($exam['title']); ?></td>
                    <td style="padding:8px; text-align:center;"><?php echo (int)$exam['total_marks']; ?></td>
                    <td style="padding:8px; text-align:center;"><?php echo (int)$exam['time_limit']; ?></td>
                    <td style="padding:8px; text-align:center;"><?php echo htmlspecialchars($exam['exam_date']); ?></td>
                    <td style="padding:8px; text-align:center; white-space:nowrap;">
                        <a href="view_questions.php?exam_id=<?php echo $exam['exam_id']; ?>" class="create-exam-btn" style="background:#0b74f0; padding:5px 10px; margin-right:4px;">View Questions</a>
                        <a href="edit_exam.php?exam_id=<?php echo $exam['exam_id']; ?>" class="create-exam-btn" style="background:#28a745; padding:5px 10px; margin-right:4px;">Edit</a>
                        <a href="delete_exam.php?exam_id=<?php echo $exam['exam_id']; ?>" onclick="return confirm('Delete this exam and all its questions?');" class="create-exam-btn" style="background:#dc3545; padding:5px 10px;">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
<?php else: ?>
    <p style="margin-top:20px;">No exams found. <a href="create_exam.php">Create one</a>.</p>
<?php endif; ?>

    </div>
</div>

<?php include("../includes/footer.php"); ?>
