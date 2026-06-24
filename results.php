<?php
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

// Ensure student is logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit;
}

$student_id = $_SESSION['student_id'];

// =====================================
// FETCH RESULTS (NO get_result USED)
// =====================================
$sql = "
    SELECT r.exam_id, r.score, e.title
    FROM results r
    JOIN exams e ON r.exam_id = e.exam_id
    WHERE r.student_id = ?
    ORDER BY r.result_id DESC
";

$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $student_id);
$stmt->execute();
$stmt->store_result();

$stmt->bind_result($exam_id, $score, $exam_title);

?>
<!DOCTYPE html>
<html>
<head>
    <title>My Results</title>
    <link rel="stylesheet" href="../assets/css/style.css">
    <style>
        body { background:#f4f4f4; font-family:Arial; }
        .container {
            width: 800px; margin:60px auto; background:#fff;
            padding:25px; border-radius:10px; 
            box-shadow:0 0 10px rgba(0,0,0,0.1);
        }
        table { width:100%; border-collapse:collapse; margin-top:20px; }
        th, td { border:1px solid #ccc; padding:10px; text-align:center; }
        th { background:#0d6efd; color:white; }
        h2 { text-align:center; }
        .no-data { text-align:center; padding:20px; font-size:18px; }
    </style>
</head>
<body>

<div class="container">
    <h2>My Exam Results</h2>

    <?php if ($stmt->num_rows > 0) { ?>

    <table>
        <tr>
            <th>Exam Title</th>
            <th>Score</th>
            <th>Total Questions</th>
            <th>Percentage</th>
        </tr>

        <?php
        while ($stmt->fetch()) {

            // Count total questions for this exam
            $q_sql = "SELECT COUNT(*) FROM questions1 WHERE exam_id = ?";
            $q_stmt = $conn->prepare($q_sql);
            $q_stmt->bind_param("i", $exam_id);
            $q_stmt->execute();
            $q_stmt->bind_result($total_questions);
            $q_stmt->fetch();
            $q_stmt->close();

            $percent = ($total_questions > 0) 
                       ? round(($score / $total_questions) * 100, 2)
                       : 0;
        ?>

        <tr>
            <td><?php echo htmlspecialchars($exam_title); ?></td>
            <td><?php echo $score; ?></td>
            <td><?php echo $total_questions; ?></td>
            <td><?php echo $percent . "%"; ?></td>
        </tr>

        <?php } ?>

    </table>

    <?php } else { ?>
        <p class="no-data">No exam results found.</p>
    <?php } ?>

</div>

</body>
</html>
