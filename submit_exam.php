<?php
session_start();
include("../config/db.php");
include("../includes/header.php");

$student_id = $_SESSION['student_id'];
?>

<style>
.result-box {
    max-width: 700px;
    margin: 50px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.15);
    text-align: center;
}
.correct-answer { background:#e8f5e9; padding:10px; border-left:5px solid #4caf50; margin:10px 0; }
.wrong-answer { background:#ffebee; padding:10px; border-left:5px solid #f44336; margin:10px 0; }
.score { font-size:22px; font-weight:bold; color:#2a73ff; }
</style>

<div class="result-box">

<?php
if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    echo "<h2>Error: Invalid Access!</h2>";
    exit;
}

$subject = $_POST['subject'];
$score = 0;

/* ----------------------------------------------------------
   CORRECT ANSWERS FOR ALL SUBJECTS (MATCHING YOUR QUESTIONS)
------------------------------------------------------------*/
$answers = array(

    // ---------------- C LANGUAGE ----------------
    "c" => array(
        "q1" => "int num;",
        "q2" => "//",
        "q3" => "stdio.h",
        "q4" => "*",
        "q5" => "char",
        "q6" => "do-while",
        "q7" => "4 bytes",
        "q8" => "const",
        "q9" => "strlen()",
        "q10" => "final"
    ),

    // ---------------- C++ PROGRAMMING (FIXED) ----------------
    "cpp" => array(
        "q1" => "class",
        "q2" => "::",
        "q3" => "Polymorphism",
        "q4" => ":",
        "q5" => "Binding data and functions",
        "q6" => "private",
        "q7" => "new",
        "q8" => "this",
        "q9" => ".cpp",
        "q10" => "Constructors"
    ),

    // ---------------- JAVA PROGRAMMING (FIXED) ----------------
    "java" => array(
        "q1" => "new",
        "q2" => "Pointers",
        "q3" => "main",
        "q4" => "Polymorphism",
        "q5" => "0",
        "q6" => "extends",
        "q7" => "super",
        "q8" => "JVM",
        "q9" => "friendly",
        "q10" => "try-catch"
    ),

    // ---------------- JAVASCRIPT (FIXED) ----------------
    "javascript" => array(
        "q1" => "let",
        "q2" => "() => {}",
        "q3" => "number",
        "q4" => "JSON.parse",
        "q5" => "//",
        "q6" => "character",
        "q7" => "true",
        "q8" => "setTimeout",
        "q9" => "type and value",
        "q10" => "alert('Hello World')"
    ),

    // ---------------- PYTHON (FIXED) ----------------
    "python" => array(
        "q1" => "def",
        "q2" => "#",
        "q3" => "[1, 2, 3]",
        "q4" => "<class 'int'>",
        "q5" => "**",
        "q6" => "1",
        "q7" => "True",   // according to your exam_page for q7
        "q8" => "lambda x: x * 2",  // example
        "q9" => "append()", 
        "q10" => "class" 
    ),

    // ---------------- CYBER SECURITY ----------------
    "cyber" => array(
        "q1" => "Confidentiality, Integrity, Availability",
        "q2" => "Virus",
        "q3" => "Fraudulent attempt to get sensitive data",
        "q4" => "HTTPS",
        "q5" => "Converting data to unreadable form",
        "q6" => "Using letters, numbers & symbols",
        "q7" => "To block unauthorized access",
        "q8" => "Two different proofs required to login",
        "q9" => "A software flaw unknown to vendor",
        "q10" => "Validate user input"
    ),

    // ---------------- PHP FRAMEWORK ----------------
    "php_framework" => array(
        "q1" => "Laravel",
        "q2" => "Laravel",
        "q3" => "composer create-project --prefer-dist laravel/laravel",
        "q4" => "routes/web.php",
        "q5" => "Slim",
        "q6" => "php artisan migrate",
        "q7" => "app/Http/Controllers",
        "q8" => "Blade",
        "q9" => "Symfony",
        "q10" => "php artisan make:controller"
    ),

    // ---------------- GRAPHICS ----------------
    "graphics" => array(
        "q1" => "Adobe Illustrator",
        "q2" => "Dots Per Inch",
        "q3" => "CMYK",
        "q4" => "Graphics made of paths and curves",
        "q5" => "Adobe Photoshop",
        "q6" => "Graphics made of pixels",
        "q7" => "PNG",
        "q8" => "Blender",
        "q9" => "Smoothing of jagged edges",
        "q10" => "Generating an image from model/data"
    ),

    // ---------------- DIGITAL MARKETING ----------------
    "digital_marketing" => array(
        "q1" => "Search Engine Optimization",
        "q2" => "Page Views",
        "q3" => "Pay Per Click",
        "q4" => "Facebook",
        "q5" => "Cost Per Click",
        "q6" => "Percentage of users who complete a goal",
        "q7" => "Sending promotional emails",
        "q8" => "Creating and sharing content",
        "q9" => "Google Analytics",
        "q10" => "Percentage of visitors leaving without interacting"
    ),

    // ---------------- AI / ML ----------------
    "ai_ml" => array(
        "q1" => "A type of AI that learns from data",
        "q2" => "Learning from labeled data",
        "q3" => "Decision Tree",
        "q4" => "When a model learns noise and not the signal",
        "q5" => "Convolutional Neural Network",
        "q6" => "Learning from unlabeled data",
        "q7" => "PCA",
        "q8" => "Learning by trial and error",
        "q9" => "Accuracy",
        "q10" => "scikit-learn"
    ),
);


/* ------------------------------------------------------------------
   BEGIN GRADING
------------------------------------------------------------------ */
echo "<h2>Your Exam Result</h2>";

foreach ($answers[$subject] as $q => $correct) {

   $user_ans = isset($_POST[$q]) ? $_POST[$q] : "Not Attempted";

    if ($user_ans === $correct) {
        $score++;
        echo "<div class='correct-answer'><b>$q:</b> Correct</div>";
    } else {
        echo "<div class='wrong-answer'>
                <b>$q:</b> Wrong<br>
                Your answer: $user_ans<br>
                Correct answer: $correct
              </div>";
    }
}

echo "<h3 class='score'>Score: $score / 10</h3>";

?>
<?php

$check = mysqli_query($conn,
    "SELECT * FROM results
     WHERE user_id='$student_id'
     AND subject='$subject'"
);

if (mysqli_num_rows($check) == 0) {

    $insert = mysqli_query($conn,
        "INSERT INTO results(user_id, subject, score)
         VALUES('$student_id', '$subject', '$score')"
    );

    if(!$insert){
        die("Insert Error: " . mysqli_error($conn));
    }
}
?>
<a href="view_exams.php" class="btn btn-primary">Back to Exams</a>

</div>

<?php include("../includes/footer.php"); ?>
