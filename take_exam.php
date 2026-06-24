<?php
session_start();

// Redirect if student not logged in
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

require_once "../config/db.php";

// Validate exam_id
if (!isset($_GET['exam_id']) || empty($_GET['exam_id'])) {
    die("Invalid exam id. exam_id missing in URL");
}

$exam_id = intval($_GET['exam_id']);


// =========================
// FETCH EXAM (NO get_result)
// =========================
$exam_stmt = $conn->prepare("SELECT exam_id, title FROM exams WHERE exam_id = ? LIMIT 1");
if (!$exam_stmt) {
    die("Exam Query Error: " . $conn->error);
}

$exam_stmt->bind_param("i", $exam_id);
$exam_stmt->execute();
$exam_stmt->store_result();

if ($exam_stmt->num_rows == 0) {
    die("Exam not found in database (exam_id = $exam_id)");
}

$exam_stmt->bind_result($exam_id_db, $exam_title);
$exam_stmt->fetch();
$exam_stmt->close();


// ==============================
// FETCH QUESTIONS (NO get_result)
// ==============================
$q_stmt = $conn->prepare("
    SELECT id AS question_id, question, option_a, option_b, option_c, option_d, correct_answer
    FROM questions1 
    WHERE exam_id = ?
    ORDER BY id ASC
");


if (!$q_stmt) {
    die("Question Query Error: " . $conn->error);
}

$q_stmt->bind_param("i", $exam_id);
$q_stmt->execute();
$q_stmt->store_result();

if ($q_stmt->num_rows == 0) {
    die("No questions found for exam_id = $exam_id");
}

$q_stmt->bind_result($qid, $q_text, $opa, $opb, $opc, $opd, $correct);


// ==============================
// LOAD QUESTIONS INTO ARRAY
// ==============================
$questions = array();
while ($q_stmt->fetch()) {
    $questions[] = array(
        "question_id" => $qid,
        "question" => $q_text,
        "option_a" => $opa,
        "option_b" => $opb,
        "option_c" => $opc,
        "option_d" => $opd,
        "correct_answer" => $correct
    );
}

$q_stmt->close();

$total_questions = count($questions);


// ==============================
// TRACK CURRENT QUESTION
// ==============================
if (!isset($_SESSION['current_q']) || $_SESSION['current_exam_id'] != $exam_id) {
    $_SESSION['current_q'] = 0;
    $_SESSION['answers'] = array();
    $_SESSION['current_exam_id'] = $exam_id;
}

$current_q = $_SESSION['current_q'];

if ($current_q >= $total_questions) {
    header("Location: submit_exam1.php?exam_id=$exam_id");
    exit();
}

$current_question = $questions[$current_q];


// ==============================
// HANDLE ANSWER SUBMISSION
// ==============================
if ($_SERVER['REQUEST_METHOD'] == "POST") {

    if (isset($_POST['answer'])) {
        $selected = strtoupper(trim($_POST['answer']));
        $_SESSION['answers'][$current_question['question_id']] = $selected;
    }

    $_SESSION['current_q']++;

    if ($_SESSION['current_q'] >= $total_questions) {
        header("Location: submit_exam1.php?exam_id=$exam_id");
        exit();
    }

    header("Location: take_exam.php?exam_id=<?php echo $exam_id; ?>");
    exit();
}

include("../includes/header.php");
?>

<div class="content-wrapper">
    <div class="create-exam-container" style="max-width:750px;">

        <h2><?php echo htmlspecialchars($exam_title); ?></h2>
        <p><b>Question <?php echo ($current_q + 1); ?> of <?php echo $total_questions; ?></b></p>

        <form method="POST" action="take_exam.php?exam_id=<?php echo $exam_id; ?>">
            <h3><?php echo htmlspecialchars($current_question['question']); ?></h3>

            <div style="margin-top:20px; line-height:30px;">
                <label><input type="radio" name="answer" value="A" required>
                       A. <?php echo htmlspecialchars($current_question['option_a']); ?></label><br>

                <label><input type="radio" name="answer" value="B">
                       B. <?php echo htmlspecialchars($current_question['option_b']); ?></label><br>

                <label><input type="radio" name="answer" value="C">
                       C. <?php echo htmlspecialchars($current_question['option_c']); ?></label><br>

                <label><input type="radio" name="answer" value="D">
                       D. <?php echo htmlspecialchars($current_question['option_d']); ?></label><br>
            </div>

            <button type="submit"
                style="margin-top:20px; padding:10px 20px; background:#1e56d8; color:white; border:none; border-radius:5px; cursor:pointer;">
                Next
            </button>
        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>
