<?php
session_start();
include("../config/db.php"); // DB connection
include("../includes/header.php"); // header

// ================== FETCH ALL SUBJECTS ==================
$subjects_result = mysqli_query($conn, "SELECT * FROM subjects");
if (!$subjects_result) {
    die("Error fetching subjects: " . mysqli_error($conn));
}
$subjects = array();
while ($row = mysqli_fetch_assoc($subjects_result)) {
    $subjects[] = $row;
}

// ================== ASSIGN MULTIPLE SUBJECTS ==================
$message = "";
if (isset($_POST['assign'])) {
    $student_id = $_POST['student_id'];
    $subject_ids = isset($_POST['subject_id']) ? $_POST['subject_id'] : array(); // Array of selected subjects
    $success = 0;

    // Check if student exists
    $student_check = mysqli_query($conn, "SELECT * FROM students WHERE id = '$student_id'");
    if (!$student_check || mysqli_num_rows($student_check) == 0) {
        $message = "Invalid student selected!";
    } else {
        foreach ($subject_ids as $subject_id) {
            // Check if subject exists
            $subject_check = mysqli_query($conn, "SELECT * FROM subjects WHERE id = '$subject_id'");
            if (!$subject_check || mysqli_num_rows($subject_check) == 0) {
                continue; // skip invalid subjects
            }

            // Prevent duplicate insert
            $check = mysqli_query($conn, "
                SELECT * FROM student_subjects 
                WHERE student_id = '$student_id' AND subject_id = '$subject_id'
            ");

            if (!$check) {
                die("Error checking existing assignment: " . mysqli_error($conn));
            }

            if (mysqli_num_rows($check) == 0) {
                $sql = "INSERT INTO student_subjects(student_id, subject_id) VALUES('$student_id', '$subject_id')";
                if (!mysqli_query($conn, $sql)) {
                    die("Error inserting subject: " . mysqli_error($conn));
                } else {
                    $success++;
                }
            }
        }

        if ($success > 0) {
            $message = "Subjects Assigned Successfully!";
        } else {
            $message = "No new subjects were assigned (maybe duplicates).";
        }
    }
}

// ================== FETCH ALL STUDENTS ==================
$students_result = mysqli_query($conn, "SELECT * FROM students");
if (!$students_result) {
    die("Error fetching students: " . mysqli_error($conn));
}
$students = array();
while ($row = mysqli_fetch_assoc($students_result)) {
    $students[] = $row;
}
?>

<!DOCTYPE html>
<html>
<head>
    <!-- Select2 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <!-- Select2 JS -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <title>Assign Subjects</title>
    <style>
        body { font-family: Arial; background: #f1f1f1; }
        table { width: 80%; margin: auto; border-collapse: collapse; background:white; }
        th, td { padding: 10px; border: 1px solid black; }
        th { background: #1e56d8; color:white; }
        .msg { 
            color: green; 
            text-align: center; 
            font-weight: bold; 
            padding:10px; 
            font-size:18px;
        }
        select[multiple] {
            height: 90px; 
            width: 180px; 
        }
        button {
            background: #1e56d8;
            color: white;
            border: none;
            padding: 8px 15px;
            border-radius: 5px;
        }
        button:hover {
            background: #1440a3;
            cursor:pointer;
        }
    </style>
</head>
<body>

<h2 style="text-align:center; margin-top:20px;">Assign Subjects to Students</h2>

<?php if (!empty($message)) echo "<p class='msg'>$message</p>"; ?>

<table>
    <tr>
        <th>Student Name</th>
        <th>Enrollment No</th>
        <th>Select Subjects</th>
        <th>Action</th>
    </tr>

    <?php foreach ($students as $student) { ?>
        <tr>
            <form method="POST">
                <td><?php echo htmlspecialchars($student['name']); ?></td>
                <td><?php echo htmlspecialchars($student['enrollment']); ?></td>

                <td>
                    <select class="subject-select" name="subject_id[]" multiple="multiple" required>
                        <?php foreach ($subjects as $sub) { ?>
                            <option value="<?php echo $sub['id']; ?>"><?php echo htmlspecialchars($sub['subject_name']); ?></option>
                        <?php } ?>
                    </select>
                </td>

                <td>
                    <input type="hidden" name="student_id" value="<?php echo $student['id']; ?>">
                    <button type="submit" name="assign">Assign</button>
                </td>
            </form>
        </tr>
    <?php } ?>
</table>

<script>
$(document).ready(function() {
    $('.subject-select').select2({
        placeholder: "Select Subjects",
        allowClear: true
    });
});
</script>

</body>
</html>
