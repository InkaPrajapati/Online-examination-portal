<?php
session_start();

// If student is not logged in → redirect
if (!isset($_SESSION['student_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
include("../config/db.php");   // Database connection
include("../includes/header.php");
?>

<div style="max-width:900px; margin:30px auto; font-family:Arial, sans-serif;">

    <!-- Welcome Card -->
    <div style="background: linear-gradient(to right, #1e56d8, #3b78e7); color:white; 
                padding:20px; border-radius:10px; text-align:center; box-shadow: 0 4px 8px rgba(0,0,0,0.1);">
        <h2 style="margin:0; font-size:28px;">Welcome, <?php echo htmlspecialchars($_SESSION['student_name']); ?> 👋</h2>
        <p style="margin:5px 0 0 0; font-size:16px;">This is your student dashboard.</p>
    </div>

    <?php
    $student_id = $_SESSION['student_id'];

    // Fetch assigned subjects
    $query = mysqli_query($conn, "
        SELECT s.subject_name 
        FROM student_subjects ss
        JOIN subjects s ON ss.subject_id = s.id
        WHERE ss.student_id = '$student_id'
    ");

    echo "<div style='margin-top:30px;'>";
    echo "<h3 style='color:#1e56d8; text-align:center;'>Your Assigned Subjects</h3>";

    if ($query && mysqli_num_rows($query) > 0) {
        echo "<div style='display:flex; flex-wrap:wrap; gap:15px; justify-content:center;'>";
        while ($row = mysqli_fetch_assoc($query)) {
            echo "<div style='background:#f0f4ff; padding:20px 25px; border-radius:10px; 
                        min-width:180px; text-align:center; font-weight:bold; color:#1e56d8;
                        box-shadow: 0 3px 6px rgba(0,0,0,0.1); transition: transform 0.2s;'>
                      " . htmlspecialchars($row['subject_name']) . "
                  </div>";
        }
        echo "</div>";
    } else {
        // Friendly message when no subjects are assigned
        echo "<p style='color:#555; text-align:center; font-size:16px; margin-top:20px;'>
                You have not been assigned any subjects yet. Please contact your administrator.
              </p>";
    }
    echo "</div>";
    ?>

    <!-- Student Menu -->
    <div style="margin-top:40px; background:#f8f9ff; padding:25px; border-radius:10px; text-align:center;
                box-shadow: 0 4px 8px rgba(0,0,0,0.05);">
        <h3 style="margin-bottom:15px;">Student Menu</h3>
        <ul style="list-style:none; padding:0; display:flex; justify-content:center; flex-wrap:wrap; gap:15px;">
            <li>
                <a href="my_exams.php"
                   style="text-decoration:none; background:#1e56d8; padding:12px 20px; color:white; 
                   border-radius:5px; display:inline-block; min-width:180px; text-align:center; font-weight:bold;">Start Exam</a>
            </li>
            <li>
                <a href="results.php"
                   style="text-decoration:none; background:#1e56d8; padding:12px 20px; color:white; 
                   border-radius:5px; display:inline-block; min-width:180px; text-align:center; font-weight:bold;">View Results</a>
            </li>
            <li>
                <a href="profile.php"
                   style="text-decoration:none; background:#1e56d8; padding:12px 20px; color:white; 
                   border-radius:5px; display:inline-block; min-width:180px; text-align:center; font-weight:bold;">Profile Settings</a>
            </li>
            <li>
                <a href="view_subjects.php"
                   style="text-decoration:none; background:#1e56d8; padding:12px 20px; color:white; 
                   border-radius:5px; display:inline-block; min-width:180px; text-align:center; font-weight:bold;">View Subjects</a>
            </li>
            <li>
                <a href="../auth/logout.php"
                   style="text-decoration:none; background:#dc3545; padding:12px 20px; color:white; 
                   border-radius:5px; display:inline-block; min-width:180px; text-align:center; font-weight:bold;">Logout</a>
            </li>
        </ul>
    </div>

</div>

<?php include("../includes/footer.php"); ?>