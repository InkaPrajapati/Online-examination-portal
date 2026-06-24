<?php
session_start();

// Only admin allowed
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}

require_once("../config/db.php");

// If POST -> handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // Required fields
    $exam_id     = isset($_POST['exam_id']) ? intval($_POST['exam_id']) : 0;
    $title       = isset($_POST['title']) ? trim($_POST['title']) : '';
    $description = isset($_POST['description']) ? trim($_POST['description']) : '';
    $total_marks = isset($_POST['total_marks']) ? intval($_POST['total_marks']) : 0;
    $time_limit  = isset($_POST['time_limit']) ? intval($_POST['time_limit']) : 0;
    $exam_date   = isset($_POST['exam_date']) ? trim($_POST['exam_date']) : '';

    // Basic validation
    if ($exam_id <= 0 || $title === '' || $total_marks <= 0 || $time_limit <= 0 || $exam_date === '') {
        echo "<script>alert('Please fill all required fields correctly.'); window.history.back();</script>";
        exit();
    }

    // Update using prepared statement
    $sql = "UPDATE exams 
            SET title = ?, description = ?, total_marks = ?, time_limit = ?, exam_date = ?
            WHERE exam_id = ?";

    $stmt = $conn->prepare($sql);
    if (!$stmt) {
        die("Prepare failed: " . $conn->error);
    }

    $stmt->bind_param("ssiisi", $title, $description, $total_marks, $time_limit, $exam_date, $exam_id);

    if ($stmt->execute()) {
        echo "<script>alert('Exam updated successfully.'); window.location.href='exams_list.php';</script>";
        $stmt->close();
        exit();
    } else {
        $err = $stmt->error;
        $stmt->close();
        echo "<script>alert('Failed to update exam: " . addslashes($err) . "'); window.history.back();</script>";
        exit();
    }
}

// ---------- GET: show form ----------
if (!isset($_GET['exam_id']) || intval($_GET['exam_id']) <= 0) {
    header("Location: exams_list.php");
    exit();
}

$exam_id = intval($_GET['exam_id']);

// Fetch exam
$sql = "SELECT exam_id, title, description, total_marks, time_limit, exam_date FROM exams WHERE exam_id = ? LIMIT 1";
$stmt = $conn->prepare($sql);
if (!$stmt) {
    die("Prepare failed: " . $conn->error);
}

$stmt->bind_param("i", $exam_id);
$stmt->execute();

$stmt->store_result();

if ($stmt->num_rows === 0) {
    $stmt->close();
    echo "<script>alert('Exam not found.'); window.location.href='exams_list.php';</script>";
    exit();
}

$stmt->bind_result($eid, $title, $description, $total_marks, $time_limit, $exam_date);
$stmt->fetch();

$exam = array(
    "exam_id"      => $eid,
    "title"        => $title,
    "description"  => $description,
    "total_marks"  => $total_marks,
    "time_limit"   => $time_limit,
    "exam_date"    => $exam_date
);

$stmt->close();

include("../includes/header.php");
?>

<div class="content-wrapper">
    <div class="create-exam-container" style="max-width:700px;">

        <h2>Edit Exam</h2>
        <p>Change the details and click <strong>Save</strong>.</p>

        <form action="edit_exam.php" method="POST" class="create-exam-form">
            <input type="hidden" name="exam_id" value="<?php echo (int)$exam['exam_id']; ?>">

            <label>Exam Title</label>
            <input type="text" name="title" required value="<?php echo htmlspecialchars($exam['title']); ?>">

            <label>Description</label>
            <textarea name="description"><?php echo htmlspecialchars($exam['description']); ?></textarea>

            <label>Total Marks</label>
            <input type="number" name="total_marks" required min="1" value="<?php echo (int)$exam['total_marks']; ?>">

            <label>Time Limit (minutes)</label>
            <input type="number" name="time_limit" required min="1" value="<?php echo (int)$exam['time_limit']; ?>">

            <label>Exam Date</label>
            <input type="date" name="exam_date" required value="<?php echo htmlspecialchars($exam['exam_date']); ?>">

            <div style="display:flex; gap:10px; margin-top:15px;">
                <button type="submit" class="create-exam-btn">Save Changes</button>
                <button type="button" onclick="window.location.href='exams_list.php'" class="btn btn-danger">
                    Cancel
                </button>
            </div>
        </form>

    </div>
</div>

<?php include("../includes/footer.php"); ?>
