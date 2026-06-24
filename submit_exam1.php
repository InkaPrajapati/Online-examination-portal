<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// Check exam ID
if (!isset($_GET['exam_id'])) {
    die("Invalid exam submission.");
}

$exam_id = intval($_GET['exam_id']);

// Ensure session exam matches
if (!isset($_SESSION['current_exam_id']) || $_SESSION['current_exam_id'] != $exam_id) {
    die("Invalid exam attempt.");
}

// Ensure answers exist
if (!isset($_SESSION['answers']) || empty($_SESSION['answers'])) {
    die("No answers found.");
}

// Fetch correct answers from DB
$sql = "SELECT question_id, correct_answer FROM questions1 WHERE exam_id = ?";
$stmt = $conn->prepare($sql);

if (!$stmt) {
    die("SQL Error: " . $conn->error);
}

$stmt->bind_param("i", $exam_id);
$stmt->execute();
$stmt->store_result();
$stmt->bind_result($qid, $correct);

$total_questions = $stmt->num_rows;
$score = 0;

// Compare answers
while ($stmt->fetch()) {
    if (isset($_SESSION['answers'][$qid])) {
        if ($_SESSION['answers'][$qid] === $correct) {
            $score++;
        }
    }
}
$stmt->close();

// -------- Insert Result into DB --------
$sql_insert = "INSERT INTO results (student_id, exam_id, score) VALUES (?, ?, ?)";
$stmt_insert = $conn->prepare($sql_insert);

if (!$stmt_insert) {
    die("Insert Error: " . $conn->error);
}

$stmt_insert->bind_param("iii", $student_id, $exam_id, $score);
$stmt_insert->execute();
$stmt_insert->close();

// Clear session exam data
unset($_SESSION['current_q']);
unset($_SESSION['answers']);
unset($_SESSION['current_exam_id']);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Exam Submitted</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background:#f7f7f7; font-family:Arial; }
        .result-box {
            width: 400px; margin:100px auto; background:#fff; padding:25px;
            text-align:center; border-radius:8px; box-shadow:0 0 10px #ccc;
        }
    </style>
</head>
<body>

<div class="result-box">
    <h2>Exam Submitted Successfully</h2>
    <p>Your Score:</p>
    <h1><?php echo $score . " / " . $total_questions; ?></h1>

    <a href="dashboard.php"
       style="display:inline-block; margin-top:20px; padding:10px 20px; background:#007bff; color:#fff; text-decoration:none; border-radius:5px;">
        Back to Dashboard
    </a>
</div>

</body>
</html>
