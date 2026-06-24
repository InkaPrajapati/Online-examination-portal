<?php
session_start();

// Redirect if admin not logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';

// Fetch all exams
$exams_query = "SELECT exam_id, title FROM exams ORDER BY exam_id DESC";
$exams_result = $conn->query($exams_query);

if (!$exams_result) {
    die("Query failed: " . $conn->error);
}
?>

<div class="content-wrapper">
    <div class="create-exam-container">
        <h2>Add Questions</h2>
        <p>Select an exam and add a new MCQ question.</p>

        <form action="save_question.php" method="POST" class="create-exam-form">

            <label>Select Exam</label>
            <select name="exam_id" required>
                <option value="">-- Choose Exam --</option>

                <?php while ($row = $exams_result->fetch_assoc()): ?>
                    <option value="<?php echo $row['exam_id']; ?>">
						<?php echo htmlspecialchars($row['title']); ?>
                    </option>
                <?php endwhile; ?>

            </select>

            <label>Question</label>
            <textarea name="question" rows="3" required placeholder="Enter question..."></textarea>

            <label>Option A</label>
            <input type="text" name="option_a" required>

            <label>Option B</label>
            <input type="text" name="option_b" required>

            <label>Option C</label>
            <input type="text" name="option_c" required>

            <label>Option D</label>
            <input type="text" name="option_d" required>

            <label>Correct Answer</label>
            <select name="correct_answer" required>
                <option value="">-- Select Correct Answer --</option>
                <option value="A">A</option>
                <option value="B">B</option>
                <option value="C">C</option>
                <option value="D">D</option>
            </select>

            <input type="submit" value="Add Question" class="create-exam-btn">

        </form>
    </div>
</div>

<?php include("../includes/footer.php"); ?>
