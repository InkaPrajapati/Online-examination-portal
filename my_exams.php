<?php
session_start();
if (!isset($_SESSION['student_id'])) {
    header("Location: ../index.php");
    exit;
}

include("../config/db.php");
$student_id = (int)$_SESSION['student_id']; // ensure integer

// Fetch exams and check if attempted
$query = "
    SELECT e.*,
    (SELECT COUNT(*) 
     FROM results r 
     WHERE r.exam_id = e.exam_id AND r.student_id = $student_id) AS attempted
    FROM exams e
    ORDER BY e.exam_id DESC
";

$result = mysqli_query($conn, $query);
if (!$result) {
    die("Query failed: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>My Exams</title>
    <link rel="stylesheet" href="../css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>
<?php include("../includes/header.php"); ?>

<div class="container mt-4">
    <h2 class="mb-4">Available Exams</h2>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>Exam Title</th>
                <th>Total Marks</th>
                <th>Date</th>
                <th>Duration</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = mysqli_fetch_assoc($result)) { ?>
            <tr>
                <td><?php echo htmlspecialchars($row['title']); ?></td>
                <td><?php echo $row['total_marks']; ?></td>
                <td><?php echo $row['exam_date']; ?></td>
                <td><?php echo $row['time_limit']; ?> min</td>
                <td>
                    <?php if ($row['attempted'] > 0) { ?>
                        <button class="btn btn-secondary" disabled>Attempted</button>
                    <?php } else { ?>
                        <a href="exam_rules.php?exam_id=<?php echo $row['exam_id']; ?>" class="btn btn-primary">Start Exam</a>
                    <?php } ?>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

</body>
</html>
