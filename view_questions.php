<?php
session_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}

require_once("../config/db.php");
include("../includes/header.php");

if (!isset($_GET['exam_id'])) {
    echo "<div class='content-wrapper'><div class='create-exam-container'><p>Invalid exam.</p></div></div>";
    include("../includes/footer.php");
    exit();
}

$exam_id = intval($_GET['exam_id']);

// Get exam title
$es = $conn->prepare("SELECT title FROM exams WHERE exam_id = ?");
if (!$es) { die("Prepare failed (exam title): " . $conn->error); }

$es->bind_param("i", $exam_id);
$es->execute();
$es->bind_result($exam_title);
$es->fetch();
$es->close();
?>

<div class="content-wrapper">
    <div class="create-exam-container" style="max-width:1000px;">
        <h2>Questions for: <?php echo htmlspecialchars($exam_title); ?></h2>

        <div style="margin-bottom:12px;">
            <a href="add_questions.php?exam_id=<?php echo $exam_id; ?>" class="create-exam-btn" style="padding:8px 12px;">Add Question</a>
            <a href="exams_list.php" class="create-exam-btn" style="background:#777;padding:8px 12px;">Back to Exams</a>
        </div>

        <?php
        // MAIN QUESTION QUERY WITH ERROR CHECK
        $q = $conn->prepare(
            "SELECT question_id, question, option_a, option_b, option_c, option_d, correct_answer 
             FROM questions1
             WHERE exam_id = ? 
             ORDER BY question_id ASC"
        );

        if (!$q) {
            die("Prepare failed (questions query): " . $conn->error);
        }

        $q->bind_param("i", $exam_id);
        $q->execute();
        $q->store_result();
        $q->bind_result($question_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer);
        ?>

        <?php if ($q->num_rows > 0): ?>
            <table style="width:100%; border-collapse:collapse;">
                <thead>
                    <tr style="background:#1e56d8; color:white;">
                        <th style="padding:10px; text-align:left;">Question</th>
                        <th style="padding:10px; text-align:center;">Options</th>
                        <th style="padding:10px; text-align:center;">Correct</th>
                        <th style="padding:10px; text-align:center;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                <?php while ($q->fetch()): ?>
                    <tr style="border-bottom:1px solid #eee;">
                        <td style="padding:10px;"><?php echo htmlspecialchars($question); ?></td>
                        <td style="padding:10px; text-align:center;">
                            A. <?php echo htmlspecialchars($option_a); ?><br>
                            B. <?php echo htmlspecialchars($option_b); ?><br>
                            C. <?php echo htmlspecialchars($option_c); ?><br>
                            D. <?php echo htmlspecialchars($option_d); ?>
                        </td>
                        <td style="padding:10px; text-align:center;"><?php echo htmlspecialchars($correct_answer); ?></td>
                        <td style="padding:10px; text-align:center;">
                            <a href="edit_question.php?question_id=<?php echo $question_id; ?>" class="create-exam-btn" style="background:#28a745;padding:6px 10px;margin-right:6px;">Edit</a>
                            <a href="delete_question.php?question_id=<?php echo $question_id; ?>&exam_id=<?php echo $exam_id; ?>" onclick="return confirm('Delete this question?');" class="create-exam-btn" style="background:#dc3545;padding:6px 10px;">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                </tbody>
            </table>
        <?php else: ?>
            <p>No questions found for this exam.</p>
        <?php endif; ?>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
