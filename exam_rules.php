<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

// Validate exam_id
if (!isset($_GET['exam_id'])) {
    die("Invalid exam.");
}

$exam_id = intval($_GET['exam_id']);

// Fetch exam info using bind_result
$sql = "SELECT exam_id, title FROM exams WHERE exam_id = ?";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}
$stmt->bind_param("i", $exam_id);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows == 0) {
    die("Exam not found.");
}

// Bind columns
$stmt->bind_result($eid, $title);
$stmt->fetch();
$stmt->close();

// Count total questions dynamically
$q_sql = "SELECT COUNT(*) FROM questions1 WHERE exam_id = ?";
$q_stmt = $conn->prepare($q_sql);
if (!$q_stmt) {
    die("Prepare failed (questions count): " . $conn->error);
}

$q_stmt->bind_param("i", $exam_id);
$q_stmt->execute();
$q_stmt->bind_result($total_questions);
$q_stmt->fetch();
$q_stmt->close();


// Include header
include("../includes/header.php");
?>

<div class="content-wrapper" style="max-width:700px; margin:50px auto; background:#fff; padding:30px; border-radius:8px; box-shadow:0 0 10px #ccc;">
    <h2><?php echo htmlspecialchars($title); ?></h2>
    <p><b>Total Questions:</b> <?php echo $total_questions; ?></p>
    
    <h3>Exam Rules / Instructions:</h3>
    <ul>
        <li>Do not refresh the page during the exam.</li>
        <li>Each question is mandatory.</li>
        <li>Once submitted, answers cannot be changed.</li>
        <li>Do not use external help or open other tabs.</li>
        <li>Keep your camera/webcam on (if required).</li>
    </ul>

    <form action="take_exam.php" method="get">
        <input type="hidden" name="exam_id" value="<?php echo $exam_id; ?>">
        <button type="submit" style="padding:10px 20px; background:#1e56d8; color:white; border:none; border-radius:5px; cursor:pointer;">
            Start Exam
        </button>
    </form>
</div>

<?php
// Include footer
include("../includes/footer.php");
?>
