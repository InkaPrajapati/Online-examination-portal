<?php
session_start();
ob_start();

if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/admin_login.php");
    exit();
}

require_once "../config/db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $exam_id        = $_POST['exam_id'];
    $question       = trim($_POST['question']);
    $option_a       = trim($_POST['option_a']);
    $option_b       = trim($_POST['option_b']);
    $option_c       = trim($_POST['option_c']);
    $option_d       = trim($_POST['option_d']);
    $correct_answer = trim($_POST['correct_answer']);

    if (empty($exam_id) || empty($question) || empty($option_a) || empty($option_b) || 
        empty($option_c) || empty($option_d) || empty($correct_answer)) {

        echo "<script>
                alert('Please fill in all fields.');
                window.history.back();
              </script>";
        exit();
    }

    $stmt = $conn->prepare("
        INSERT INTO questions1 (exam_id, question, option_a, option_b, option_c, option_d, correct_answer)
        VALUES (?, ?, ?, ?, ?, ?, ?)
    ");

    $stmt->bind_param("issssss", $exam_id, $question, $option_a, $option_b, $option_c, $option_d, $correct_answer);

    if ($stmt->execute()) {
        echo "<script>
                alert('Question added successfully!');
                window.location.href = 'add_questions.php';
              </script>";
        exit();
    } else {
        echo "<script>
                alert('Error: Could not add question.');
                window.history.back();
              </script>";
    }

    $stmt->close();
}

$conn->close();
?>
