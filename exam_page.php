<?php
session_start();
include("../config/db.php"); // database connection

// Get current student ID
$student_id = $_SESSION['student_id'];

// Get selected subject
$subject = isset($_GET['subject']) ? $_GET['subject'] : "";

// Prevent invalid subject
if ($subject == "") {
    echo "Invalid Subject!";
    exit;
}

// Check if exam already attempted
$check = mysqli_query($conn,
    "SELECT * FROM exam_results
     WHERE user_id='$student_id'
     AND subject='$subject'"
);

if (!$check) {
    die("Query Failed: " . mysqli_error($conn));
}

if (mysqli_num_rows($check) == 0) {

    $insert = mysqli_query($conn,
        "INSERT INTO exam_results(user_id, subject, score)
         VALUES('$student_id', '$subject', '$score')"
    );

    if(!$insert){
        die("Insert Error: " . mysqli_error($conn));
    }
}
?>
<?php include("../includes/header.php"); ?>

<?php
$subject = isset($_GET['subject']) ? $_GET['subject'] : '';
$valid_subjects = array(
    'c', 'cpp', 'java', 'javascript', 'python',
    'cyber', 'php_framework', 'graphics', 'digital_marketing', 'ai_ml'
);
if (!in_array($subject, $valid_subjects)) {
    echo "<h2 style='text-align:center;margin-top:40px;color:red;'>Invalid Subject!</h2>";
    include("../includes/footer.php");
    exit;
}
?>

<style>
.exam-container {
    max-width: 900px;
    margin: 40px auto;
    background: #fff;
    padding: 30px;
    border-radius: 10px;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
}
.exam-container h2 {
    text-align: center;
    margin-bottom: 20px;
}
.question-box {
    padding: 20px;
    margin-bottom: 20px;
    background: #fafafa;
    border: 1px solid #ddd;
    border-radius: 8px;
}
.options label {
    display: block;
    padding: 6px 0;
    cursor: pointer;
}
.submit-btn {
    display: block;
    width: 200px;
    margin: 20px auto;
    padding: 12px 20px;
    background: #2a73ff;
    border: none;
    color: #fff;
    font-weight: bold;
    border-radius: 5px;
    cursor: pointer;
}
.timer-box {
    text-align: right;
    font-size: 20px;
    color: #d9534f;
    font-weight: bold;
    margin-bottom: 20px;
}
</style>

<div class="exam-container">

    <div class="timer-box">Time Left: <span id="timer">10:00</span></div>

    <h2>
        <?php
        // Exam title based on subject
        switch ($subject) {
            case 'c': echo "C Programming Exam"; break;
            case 'cpp': echo "C++ Programming Exam"; break;
            case 'java': echo "Java Programming Exam"; break;
            case 'javascript': echo "JavaScript Exam"; break;
            case 'python': echo "Python Exam"; break;
            case 'cyber': echo "Cyber Security Exam"; break;
            case 'php_framework': echo "PHP Framework Exam"; break;
            case 'graphics': echo "Graphics Design Exam"; break;
            case 'digital_marketing': echo "Digital Marketing Exam"; break;
            case 'ai_ml': echo "AI & Machine Learning Exam"; break;
        }
        ?>
    </h2>

    <form action="submit_exam.php" method="POST">
        <input type="hidden" name="subject" value="<?php echo $subject; ?>">

        <?php
        // ========== QUESTIONS FOR C ==========
        if ($subject === 'c') {
        ?>
            <div class="question-box">
                <h3>Q1. Which is correct syntax to declare a variable in C?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="int num;"> int num;</label>
                    <label><input type="radio" name="q1" value="integer num;"> integer num;</label>
                    <label><input type="radio" name="q1" value="num int;"> num int;</label>
                    <label><input type="radio" name="q1" value="declare int num;"> declare int num;</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which symbol is used for single line comments in C?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="//">//</label>
                    <label><input type="radio" name="q2" value="/* */">/* */</label>
                    <label><input type="radio" name="q2" value="#">#</label>
                    <label><input type="radio" name="q2" value="--">--</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which header file is required for printf()?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="stdio.h"> stdio.h</label>
                    <label><input type="radio" name="q3" value="stdlib.h"> stdlib.h</label>
                    <label><input type="radio" name="q3" value="string.h"> string.h</label>
                    <label><input type="radio" name="q3" value="math.h"> math.h</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which operator is used to access the value pointed by a pointer?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="*">*</label>
                    <label><input type="radio" name="q4" value="&">&</label>
                    <label><input type="radio" name="q4" value="->">-></label>
                    <label><input type="radio" name="q4" value="%">%</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. Which data type is used to store a single character?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="char"> char</label>
                    <label><input type="radio" name="q5" value="int"> int</label>
                    <label><input type="radio" name="q5" value="float"> float</label>
                    <label><input type="radio" name="q5" value="double"> double</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. Which loop always executes at least once?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="do-while"> do-while</label>
                    <label><input type="radio" name="q6" value="while"> while</label>
                    <label><input type="radio" name="q6" value="for"> for</label>
                    <label><input type="radio" name="q6" value="foreach"> foreach</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. What is the size of int on a typical 32-bit system?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="4 bytes"> 4 bytes</label>
                    <label><input type="radio" name="q7" value="2 bytes"> 2 bytes</label>
                    <label><input type="radio" name="q7" value="8 bytes"> 8 bytes</label>
                    <label><input type="radio" name="q7" value="depends"> depends</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. Which keyword is used to declare a constant?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="const"> const</label>
                    <label><input type="radio" name="q8" value="define"> define</label>
                    <label><input type="radio" name="q8" value="constant"> constant</label>
                    <label><input type="radio" name="q8" value="fixed"> fixed</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which function returns the length of a string?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="strlen()"> strlen()</label>
                    <label><input type="radio" name="q9" value="count()"> count()</label>
                    <label><input type="radio" name="q9" value="length()"> length()</label>
                    <label><input type="radio" name="q9" value="size()"> size()</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. Which is NOT a storage class in C?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="final"> final</label>
                    <label><input type="radio" name="q10" value="auto"> auto</label>
                    <label><input type="radio" name="q10" value="static"> static</label>
                    <label><input type="radio" name="q10" value="extern"> extern</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR C++ ==========
        if ($subject === 'cpp') {
        ?>
            <div class="question-box">
                <h3>Q1. Which keyword is used to define a class?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="class"> class</label>
                    <label><input type="radio" name="q1" value="struct"> struct</label>
                    <label><input type="radio" name="q1" value="object"> object</label>
                    <label><input type="radio" name="q1" value="define"> define</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. What is the scope resolution operator in C++?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="::"> ::</label>
                    <label><input type="radio" name="q2" value="."> .</label>
                    <label><input type="radio" name="q2" value="->"> -></label>
                    <label><input type="radio" name="q2" value=":"> :</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which OOP concept allows the same function name to have different behaviors?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="Polymorphism"> Polymorphism</label>
                    <label><input type="radio" name="q3" value="Inheritance"> Inheritance</label>
                    <label><input type="radio" name="q3" value="Encapsulation"> Encapsulation</label>
                    <label><input type="radio" name="q3" value="Abstraction"> Abstraction</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which symbol is used for inheritance in C++ class declaration?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value=":"> :</label>
                    <label><input type="radio" name="q4" value="extends"> extends</label>
                    <label><input type="radio" name="q4" value="inherits"> inherits</label>
                    <label><input type="radio" name="q4" value="->"> -></label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. What is encapsulation?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="Binding data and functions"> Binding data and functions</label>
                    <label><input type="radio" name="q5" value="Hiding data"> Hiding data</label>
                    <label><input type="radio" name="q5" value="Polymorphism"> Polymorphism</label>
                    <label><input type="radio" name="q5" value="Inheritance"> Inheritance</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. Default access specifier for class members in C++ is?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="private"> private</label>
                    <label><input type="radio" name="q6" value="public"> public</label>
                    <label><input type="radio" name="q6" value="protected"> protected</label>
                    <label><input type="radio" name="q6" value="default"> default</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. Which operator is used to allocate memory dynamically in C++?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="new"> new</label>
                    <label><input type="radio" name="q7" value="malloc"> malloc</label>
                    <label><input type="radio" name="q7" value="alloc"> alloc</label>
                    <label><input type="radio" name="q7" value="calloc"> calloc</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. Keyword to access the current object in C++?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="this"> this</label>
                    <label><input type="radio" name="q8" value="self"> self</label>
                    <label><input type="radio" name="q8" value="me"> me</label>
                    <label><input type="radio" name="q8" value="current"> current</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which file extension is for C++ source code?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value=".cpp"> .cpp</label>
                    <label><input type="radio" name="q9" value=".cc"> .cc</label>
                    <label><input type="radio" name="q9" value=".cxx"> .cxx</label>
                    <label><input type="radio" name="q9" value=".cp"> .cp</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. What cannot be inherited in C++?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="Constructors"> Constructors</label>
                    <label><input type="radio" name="q10" value="Methods"> Methods</label>
                    <label><input type="radio" name="q10" value="Fields"> Fields</label>
                    <label><input type="radio" name="q10" value="Classes"> Classes</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR JAVA ==========
        if ($subject === 'java') {
        ?>
            <div class="question-box">
                <h3>Q1. Which keyword is used to create an object in Java?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="new"> new</label>
                    <label><input type="radio" name="q1" value="create"> create</label>
                    <label><input type="radio" name="q1" value="make"> make</label>
                    <label><input type="radio" name="q1" value="instance"> instance</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which of the following is NOT a Java feature?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="Pointers"> Pointers</label>
                    <label><input type="radio" name="q2" value="Platform Independent"> Platform Independent</label>
                    <label><input type="radio" name="q2" value="Object Oriented"> Object Oriented</label>
                    <label><input type="radio" name="q2" value="Secure"> Secure</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which method is the entry point of a Java program?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="main"> main</label>
                    <label><input type="radio" name="q3" value="start"> start</label>
                    <label><input type="radio" name="q3" value="run"> run</label>
                    <label><input type="radio" name="q3" value="execute"> execute</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which concept allows method overriding?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="Polymorphism"> Polymorphism</label>
                    <label><input type="radio" name="q4" value="Inheritance"> Inheritance</label>
                    <label><input type="radio" name="q4" value="Abstraction"> Abstraction</label>
                    <label><input type="radio" name="q4" value="Encapsulation"> Encapsulation</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. What is the default value of an int in Java?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="0"> 0</label>
                    <label><input type="radio" name="q5" value="null"> null</label>
                    <label><input type="radio" name="q5" value="-1"> -1</label>
                    <label><input type="radio" name="q5" value="1"> 1</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. Which keyword is used to inherit a class in Java?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="extends"> extends</label>
                    <label><input type="radio" name="q6" value="implements"> implements</label>
                    <label><input type="radio" name="q6" value="inherit"> inherit</label>
                    <label><input type="radio" name="q6" value="super"> super</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. What keyword is used to refer to parent class object?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="super"> super</label>
                    <label><input type="radio" name="q7" value="this"> this</label>
                    <label><input type="radio" name="q7" value="parent"> parent</label>
                    <label><input type="radio" name="q7" value="base"> base</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. Java bytecode runs on which platform?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="JVM"> JVM</label>
                    <label><input type="radio" name="q8" value="JRE"> JRE</label>
                    <label><input type="radio" name="q8" value="JDK"> JDK</label>
                    <label><input type="radio" name="q8" value="Compiler"> Compiler</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which is NOT an access modifier in Java?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="friendly"> friendly</label>
                    <label><input type="radio" name="q9" value="public"> public</label>
                    <label><input type="radio" name="q9" value="private"> private</label>
                    <label><input type="radio" name="q9" value="protected"> protected</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. How do you handle exceptions in Java?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="try-catch"> try-catch</label>
                    <label><input type="radio" name="q10" value="try-finally"> try-finally</label>
                    <label><input type="radio" name="q10" value="throws"> throws</label>
                    <label><input type="radio" name="q10" value="catch-run"> catch-run</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR JavaScript ==========
        if ($subject === 'javascript') {
        ?>
            <div class="question-box">
                <h3>Q1. Which keyword declares a variable in ES6 with block scope?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="let"> let</label>
                    <label><input type="radio" name="q1" value="var"> var</label>
                    <label><input type="radio" name="q1" value="constant"> constant</label>
                    <label><input type="radio" name="q1" value="static"> static</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which of the following is an arrow function?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="() => {}"> () => { }</label>
                    <label><input type="radio" name="q2" value="function() {}"> function() { }</label>
                    <label><input type="radio" name="q2" value="new Function()"> new Function()</label>
                    <label><input type="radio" name="q2" value="func => {}"> func => { }</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. What is the result of `typeof NaN` in JavaScript?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="number"> number</label>
                    <label><input type="radio" name="q3" value="NaN"> NaN</label>
                    <label><input type="radio" name="q3" value="undefined"> undefined</label>
                    <label><input type="radio" name="q3" value="object"> object</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which method converts a JSON string to a JavaScript object?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="JSON.parse"> JSON.parse</label>
                    <label><input type="radio" name="q4" value="JSON.stringify"> JSON.stringify</label>
                    <label><input type="radio" name="q4" value="JSON.convert"> JSON.convert</label>
                    <label><input type="radio" name="q4" value="JSON.toObject"> JSON.toObject</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. How do you add a comment in JavaScript?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="//"> //</label>
                    <label><input type="radio" name="q5" value="/* */"> /* */</label>
                    <label><input type="radio" name="q5" value="<!-- -->"> <!-- --></label>
                    <label><input type="radio" name="q5" value="**"> **</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. Which of these is not a JavaScript data type?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="string"> string</label>
                    <label><input type="radio" name="q6" value="boolean"> boolean</label>
                    <label><input type="radio" name="q6" value="character"> character</label>
                    <label><input type="radio" name="q6" value="number"> number</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. What is the output of `0 == '0'` in JavaScript?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="true"> true</label>
                    <label><input type="radio" name="q7" value="false"> false</label>
                    <label><input type="radio" name="q7" value="TypeError"> TypeError</label>
                    <label><input type="radio" name="q7" value="undefined"> undefined</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. Which function is used to call a function asynchronously after a delay?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="setTimeout"> setTimeout</label>
                    <label><input type="radio" name="q8" value="setInterval"> setInterval</label>
                    <label><input type="radio" name="q8" value="setImmediate"> setImmediate</label>
                    <label><input type="radio" name="q8" value="callLater"> callLater</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. What does `===` compare in JavaScript?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="type and value"> type and value</label>
                    <label><input type="radio" name="q9" value="only value"> only value</label>
                    <label><input type="radio" name="q9" value="only type"> only type</label>
                    <label><input type="radio" name="q9" value="reference"> reference</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. How do you write "Hello World" in an alert box?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="alert('Hello World')"> alert('Hello World')</label>
                    <label><input type="radio" name="q10" value="msg('Hello World')"> msg('Hello World')</label>
                    <label><input type="radio" name="q10" value="alertBox('Hello World')"> alertBox('Hello World')</label>
                    <label><input type="radio" name="q10" value="message('Hello World')"> message('Hello World')</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR Python ==========
        if ($subject === 'python') {
        ?>
            <div class="question-box">
                <h3>Q1. Which keyword is used to define a function in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="def"> def</label>
                    <label><input type="radio" name="q1" value="function"> function</label>
                    <label><input type="radio" name="q1" value="fn"> fn</label>
                    <label><input type="radio" name="q1" value="func"> func</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which symbol is used for comments in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="#"> #</label>
                    <label><input type="radio" name="q2" value="//">//</label>
                    <label><input type="radio" name="q2" value="/*"> /*</label>
                    <label><input type="radio" name="q2" value="--"> --</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which of these is the correct way to create a list in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="[1, 2, 3]"> [1, 2, 3]</label>
                    <label><input type="radio" name="q3" value="{1, 2, 3}">{1, 2, 3}</label>
                    <label><input type="radio" name="q3" value="(1, 2, 3)">(1, 2, 3)</label>
                    <label><input type="radio" name="q3" value="<1, 2, 3>"><1, 2, 3></label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. What is the output of <code>print(type(5))</code>?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="<class 'int'>"><class 'int'></label>
                    <label><input type="radio" name="q4" value="<type 'int'>"><type 'int'></label>
                    <label><input type="radio" name="q4" value="int"> int</label>
                    <label><input type="radio" name="q4" value="number"> number</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. Which operator is used for exponentiation in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="**"> **</label>
                    <label><input type="radio" name="q5" value="^"> ^</label>
                    <label><input type="radio" name="q5" value="%"> %</label>
                    <label><input type="radio" name="q5" value="//"> //</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. What is the result of <code>3 // 2</code> in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="1"> 1</label>
                    <label><input type="radio" name="q6" value="1.5"> 1.5</label>
                    <label><input type="radio" name="q6" value="2"> 2</label>
                    <label><input type="radio" name="q6" value="0"> 0</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. Which keyword is used for conditional statement in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="if"> if</label>
                    <label><input type="radio" name="q7" value="when"> when</label>
                    <label><input type="radio" name="q7" value="switch"> switch</label>
                    <label><input type="radio" name="q7" value="cond"> cond</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. What is a correct syntax to import math module?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="import math"> import math</label>
                    <label><input type="radio" name="q8" value="include math"> include math</label>
                    <label><input type="radio" name="q8" value="using math"> using math</label>
                    <label><input type="radio" name="q8" value="from math import *"> from math import *</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which method adds an element to a list?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="append()"> append()</label>
                    <label><input type="radio" name="q9" value="add()"> add()</label>
                    <label><input type="radio" name="q9" value="push()"> push()</label>
                    <label><input type="radio" name="q9" value="insert()"> insert()</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. Which keyword is used to define a class in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="class"> class</label>
                    <label><input type="radio" name="q10" value="struct"> struct</label>
                    <label><input type="radio" name="q10" value="object"> object</label>
                    <label><input type="radio" name="q10" value="define"> define</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR Cyber Security ==========
        if ($subject === 'cyber') {
        ?>
            <div class="question-box">
                <h3>Q1. What does “CIA” stand for in cyber security?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="Confidentiality, Integrity, Availability"> Confidentiality, Integrity, Availability</label>
                    <label><input type="radio" name="q1" value="Control, Internal, Access"> Control, Internal, Access</label>
                    <label><input type="radio" name="q1" value="Cyber, Intelligence, Access"> Cyber, Intelligence, Access</label>
                    <label><input type="radio" name="q1" value="Confidential, Internet, Access"> Confidential, Internet, Access</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which is a type of malware that replicates itself?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="Virus"> Virus</label>
                    <label><input type="radio" name="q2" value="Spyware"> Spyware</label>
                    <label><input type="radio" name="q2" value="Ransomware"> Ransomware</label>
                    <label><input type="radio" name="q2" value="Adware"> Adware</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. What is “phishing”?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="Fraudulent attempt to get sensitive data"> Fraudulent attempt to get sensitive data</label>
                    <label><input type="radio" name="q3" value="A type of firewall"> A type of firewall</label>
                    <label><input type="radio" name="q3" value="Encryption algorithm"> Encryption algorithm</label>
                    <label><input type="radio" name="q3" value="Security audit"> Security audit</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which protocol is secure version of HTTP?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="HTTPS"> HTTPS</label>
                    <label><input type="radio" name="q4" value="FTP"> FTP</label>
                    <label><input type="radio" name="q4" value="SMTP"> SMTP</label>
                    <label><input type="radio" name="q4" value="TELNET"> TELNET</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. What does “encryption” mean?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="Converting data to unreadable form"> Converting data to unreadable form</label>
                    <label><input type="radio" name="q5" value="Deleting data"> Deleting data</label>
                    <label><input type="radio" name="q5" value="Compressing data"> Compressing data</label>
                    <label><input type="radio" name="q5" value="Backing up data"> Backing up data</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. Which of the following is a strong password practice?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="Using letters, numbers & symbols"> Using letters, numbers & symbols</label>
                    <label><input type="radio" name="q6" value="Using only letters"> Using only letters</label>
                    <label><input type="radio" name="q6" value="Repeating simple patterns"> Repeating simple patterns</label>
                    <label><input type="radio" name="q6" value="Using your name"> Using your name</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. What is a firewall used for?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="To block unauthorized access"> To block unauthorized access</label>
                    <label><input type="radio" name="q7" value="To speed up internet"> To speed up internet</label>
                    <label><input type="radio" name="q7" value="To store data"> To store data</label>
                    <label><input type="radio" name="q7" value="To manage files"> To manage files</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. What does “two‑factor authentication” mean?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="Two different proofs required to login"> Two different proofs required to login</label>
                    <label><input type="radio" name="q8" value="Two passwords"> Two passwords</label>
                    <label><input type="radio" name="q8" value="Login twice"> Login twice</label>
                    <label><input type="radio" name="q8" value="Two accounts"> Two accounts</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. What is a “zero‑day” vulnerability?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="A software flaw unknown to vendor"> A software flaw unknown to vendor</label>
                    <label><input type="radio" name="q9" value="A day with zero attacks"> A day with zero attacks</label>
                    <label><input type="radio" name="q9" value="A patched vulnerability"> A patched vulnerability</label>
                    <label><input type="radio" name="q9" value="A virus"> A virus</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. Which practice helps in secure coding?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="Validate user input"> Validate user input</label>
                    <label><input type="radio" name="q10" value="Trust all input"> Trust all input</label>
                    <label><input type="radio" name="q10" value="Hide errors"> Hide errors</label>
                    <label><input type="radio" name="q10" value="Disable logging"> Disable logging</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR PHP FRAMEWORK ==========
        if ($subject === 'php_framework') {
        ?>
            <div class="question-box">
                <h3>Q1. Which PHP framework is known for “convention over configuration”?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="Laravel"> Laravel</label>
                    <label><input type="radio" name="q1" value="CodeIgniter"> CodeIgniter</label>
                    <label><input type="radio" name="q1" value="Yii"> Yii</label>
                    <label><input type="radio" name="q1" value="Phalcon"> Phalcon</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which PHP framework uses Eloquent ORM?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="Laravel"> Laravel</label>
                    <label><input type="radio" name="q2" value="Symfony"> Symfony</label>
                    <label><input type="radio" name="q2" value="Zend"> Zend</label>
                    <label><input type="radio" name="q2" value="CakePHP"> CakePHP</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which command is used to create a new Laravel project via Composer?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="composer create-project --prefer-dist laravel/laravel"> composer create-project --prefer-dist laravel/laravel</label>
                    <label><input type="radio" name="q3" value="composer install laravel"> composer install laravel</label>
                    <label><input type="radio" name="q3" value="composer new laravel"> composer new laravel</label>
                    <label><input type="radio" name="q3" value="php artisan new"> php artisan new</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which file in Laravel defines the URL routes?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="routes/web.php"> routes/web.php</label>
                    <label><input type="radio" name="q4" value="app/routes.php"> app/routes.php</label>
                    <label><input type="radio" name="q4" value="config/routes.php"> config/routes.php</label>
                    <label><input type="radio" name="q4" value="public/routes.php"> public/routes.php</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. Which PHP framework is micro‑framework?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="Slim"> Slim</label>
                    <label><input type="radio" name="q5" value="Zend"> Zend</label>
                    <label><input type="radio" name="q5" value="Laravel"> Laravel</label>
                    <label><input type="radio" name="q5" value="Symfony"> Symfony</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. In Laravel, which command runs database migrations?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="php artisan migrate"> php artisan migrate</label>
                    <label><input type="radio" name="q6" value="php artisan migrate:run"> php artisan migrate:run</label>
                    <label><input type="radio" name="q6" value="composer migrate"> composer migrate</label>
                    <label><input type="radio" name="q6" value="php artisan db:migrate"> php artisan db:migrate</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. Which directory stores Laravel controllers?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="app/Http/Controllers"> app/Http/Controllers</label>
                    <label><input type="radio" name="q7" value="app/controllers"> app/controllers</label>
                    <label><input type="radio" name="q7" value="controllers"> controllers</label>
                    <label><input type="radio" name="q7" value="Http/Controllers"> Http/Controllers</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. Which templating engine is used by Laravel by default?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="Blade"> Blade</label>
                    <label><input type="radio" name="q8" value="Twig"> Twig</label>
                    <label><input type="radio" name="q8" value="Smarty"> Smarty</label>
                    <label><input type="radio" name="q8" value="Mustache"> Mustache</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which PHP framework is component-based and used for enterprise?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="Symfony"> Symfony</label>
                    <label><input type="radio" name="q9" value="CodeIgniter"> CodeIgniter</label>
                    <label><input type="radio" name="q9" value="Yii"> Yii</label>
                    <label><input type="radio" name="q9" value="Laravel"> Laravel</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. Which command generates a new controller in Laravel?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="php artisan make:controller"> php artisan make:controller</label>
                    <label><input type="radio" name="q10" value="php artisan new:controller"> php artisan new:controller</label>
                    <label><input type="radio" name="q10" value="composer controller:create"> composer controller:create</label>
                    <label><input type="radio" name="q10" value="php artisan controller:make"> php artisan controller:make</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR Graphics ==========
        if ($subject === 'graphics') {
        ?>
            <div class="question-box">
                <h3>Q1. Which tool is widely used for vector graphics?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="Adobe Illustrator"> Adobe Illustrator</label>
                    <label><input type="radio" name="q1" value="Photoshop"> Photoshop</label>
                    <label><input type="radio" name="q1" value="GIMP"> GIMP</label>
                    <label><input type="radio" name="q1" value="Corel Painter"> Corel Painter</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. What does DPI stand for?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="Dots Per Inch"> Dots Per Inch</label>
                    <label><input type="radio" name="q2" value="Dot Pixel Index"> Dot Pixel Index</label>
                    <label><input type="radio" name="q2" value="Digital Photography International"> Digital Photography International</label>
                    <label><input type="radio" name="q2" value="Depth Per Image"> Depth Per Image</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which color model is used for printing?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="CMYK"> CMYK</label>
                    <label><input type="radio" name="q3" value="RGB"> RGB</label>
                    <label><input type="radio" name="q3" value="HSV"> HSV</label>
                    <label><input type="radio" name="q3" value="HSL"> HSL</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. What is vector graphics?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="Graphics made of paths and curves"> Graphics made of paths and curves</label>
                    <label><input type="radio" name="q4" value="Pixel-based images"> Pixel-based images</label>
                    <label><input type="radio" name="q4" value="3D models"> 3D models</label>
                    <label><input type="radio" name="q4" value="Video files"> Video files</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. Which software is used for photo editing?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="Adobe Photoshop"> Adobe Photoshop</label>
                    <label><input type="radio" name="q5" value="Blender"> Blender</label>
                    <label><input type="radio" name="q5" value="Adobe After Effects"> Adobe After Effects</label>
                    <label><input type="radio" name="q5" value="Visual Studio"> Visual Studio</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. What is raster graphics?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="Graphics made of pixels"> Graphics made of pixels</label>
                    <label><input type="radio" name="q6" value="Line drawings"> Line drawings</label>
                    <label><input type="radio" name="q6" value="Text files"> Text files</label>
                    <label><input type="radio" name="q6" value="Audio files"> Audio files</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. Which file format is lossless for images?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="PNG"> PNG</label>
                    <label><input type="radio" name="q7" value="JPEG"> JPEG</label>
                    <label><input type="radio" name="q7" value="GIF"> GIF</label>
                    <label><input type="radio" name="q7" value="BMP"> BMP</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. Which tool is good for 3D graphics?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="Blender"> Blender</label>
                    <label><input type="radio" name="q8" value="Inkscape"> Inkscape</label>
                    <label><input type="radio" name="q8" value="Adobe XD"> Adobe XD</label>
                    <label><input type="radio" name="q8" value="GIMP"> GIMP</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. What is anti-aliasing?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="Smoothing of jagged edges"> Smoothing of jagged edges</label>
                    <label><input type="radio" name="q9" value="Adding more pixels"> Adding more pixels</label>
                    <label><input type="radio" name="q9" value="Color inversion"> Color inversion</label>
                    <label><input type="radio" name="q9" value="Cropping image"> Cropping image</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. What does “rendering” mean in graphics?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="Generating an image from model/data"> Generating an image from model/data</label>
                    <label><input type="radio" name="q10" value="Drawing outlines"> Drawing outlines</label>
                    <label><input type="radio" name="q10" value="Saving a file"> Saving a file</label>
                    <label><input type="radio" name="q10" value="Compressing graphics"> Compressing graphics</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR Digital Marketing ==========
        if ($subject === 'digital_marketing') {
        ?>
            <div class="question-box">
                <h3>Q1. What does SEO stand for?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="Search Engine Optimization"> Search Engine Optimization</label>
                    <label><input type="radio" name="q1" value="Social Engagement Optimization"> Social Engagement Optimization</label>
                    <label><input type="radio" name="q1" value="Search Email Optimization"> Search Email Optimization</label>
                    <label><input type="radio" name="q1" value="Social Engine Optimization"> Social Engine Optimization</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. Which metric measures number of visitors on a page?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="Page Views"> Page Views</label>
                    <label><input type="radio" name="q2" value="Bounce Rate"> Bounce Rate</label>
                    <label><input type="radio" name="q2" value="Conversion Rate"> Conversion Rate</label>
                    <label><input type="radio" name="q2" value="Click-Through Rate"> Click-Through Rate</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. What is PPC?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="Pay Per Click"> Pay Per Click</label>
                    <label><input type="radio" name="q3" value="Pay Per Conversion"> Pay Per Conversion</label>
                    <label><input type="radio" name="q3" value="Public Promotion Cost"> Public Promotion Cost</label>
                    <label><input type="radio" name="q3" value="Private Pay Cost"> Private Pay Cost</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. Which is a social media marketing platform?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="Facebook"> Facebook</label>
                    <label><input type="radio" name="q4" value="Google"> Google</label>
                    <label><input type="radio" name="q4" value="Bing"> Bing</label>
                    <label><input type="radio" name="q4" value="Yahoo"> Yahoo</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. What does CPC mean?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="Cost Per Click"> Cost Per Click</label>
                    <label><input type="radio" name="q5" value="Clicks Per Conversion"> Clicks Per Conversion</label>
                    <label><input type="radio" name="q5" value="Cost Per Conversion"> Cost Per Conversion</label>
                    <label><input type="radio" name="q5" value="Cost Per Customer"> Cost Per Customer</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. What is conversion rate?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="Percentage of users who complete a goal"> Percentage of users who complete a goal</label>
                    <label><input type="radio" name="q6" value="Rate of page loads"> Rate of page loads</label>
                    <label><input type="radio" name="q6" value="Rate of clicks"> Rate of clicks</label>
                    <label><input type="radio" name="q6" value="Rate of impressions"> Rate of impressions</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. What is email marketing?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="Sending promotional emails"> Sending promotional emails</label>
                    <label><input type="radio" name="q7" value="Posting adverts on email"> Posting adverts on email</label>
                    <label><input type="radio" name="q7" value="Emails about social media"> Emails about social media</label>
                    <label><input type="radio" name="q7" value="Emailing customers after purchase"> Emailing customers after purchase</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. What is content marketing?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="Creating and sharing content"> Creating and sharing content</label>
                    <label><input type="radio" name="q8" value="Paying for ads"> Paying for ads</label>
                    <label><input type="radio" name="q8" value="Posting direct messages"> Posting direct messages</label>
                    <label><input type="radio" name="q8" value="Cold calling"> Cold calling</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which tool is widely used for web analytics?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="Google Analytics"> Google Analytics</label>
                    <label><input type="radio" name="q9" value="Mailchimp"> Mailchimp</label>
                    <label><input type="radio" name="q9" value="Zoom"> Zoom</label>
                    <label><input type="radio" name="q9" value="Slack"> Slack</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. What is “bounce rate”?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="Percentage of visitors leaving without interacting"> Percentage of visitors leaving without interacting</label>
                    <label><input type="radio" name="q10" value="Rate of page views"> Rate of page views</label>
                    <label><input type="radio" name="q10" value="Rate of social shares"> Rate of social shares</label>
                    <label><input type="radio" name="q10" value="Rate of comments"> Rate of comments</label>
                </div>
            </div>
        <?php
        }

        // ========== QUESTIONS FOR AI & MACHINE LEARNING ==========
        if ($subject === 'ai_ml') {
        ?>
            <div class="question-box">
                <h3>Q1. What is Machine Learning?</h3>
                <div class="options">
                    <label><input type="radio" name="q1" value="A type of AI that learns from data"> A type of AI that learns from data</label>
                    <label><input type="radio" name="q1" value="A programming language"> A programming language</label>
                    <label><input type="radio" name="q1" value="A database"> A database</label>
                    <label><input type="radio" name="q1" value="A hardware device"> A hardware device</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q2. What does “supervised learning” mean?</h3>
                <div class="options">
                    <label><input type="radio" name="q2" value="Learning from labeled data"> Learning from labeled data</label>
                    <label><input type="radio" name="q2" value="Learning without data"> Learning without data</label>
                    <label><input type="radio" name="q2" value="Learning from random noise"> Learning from random noise</label>
                    <label><input type="radio" name="q2" value="Learning in real time"> Learning in real time</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q3. Which algorithm is used for classification?</h3>
                <div class="options">
                    <label><input type="radio" name="q3" value="Decision Tree"> Decision Tree</label>
                    <label><input type="radio" name="q3" value="K‑Means"> K‑Means</label>
                    <label><input type="radio" name="q3" value="Apriori"> Apriori</label>
                    <label><input type="radio" name="q3" value="PageRank"> PageRank</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q4. What is “overfitting”?</h3>
                <div class="options">
                    <label><input type="radio" name="q4" value="When a model learns noise and not the signal"> When a model learns noise and not the signal</label>
                    <label><input type="radio" name="q4" value="When a model is undertrained"> When a model is undertrained</label>
                    <label><input type="radio" name="q4" value="When a model is very fast"> When a model is very fast</label>
                    <label><input type="radio" name="q4" value="When a model forgets data"> When a model forgets data</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q5. Which neural network type is used for image recognition?</h3>
                <div class="options">
                    <label><input type="radio" name="q5" value="Convolutional Neural Network"> Convolutional Neural Network</label>
                    <label><input type="radio" name="q5" value="Recurrent Neural Network"> Recurrent Neural Network</label>
                    <label><input type="radio" name="q5" value="Feedforward Neural Network"> Feedforward Neural Network</label>
                    <label><input type="radio" name="q5" value="GAN"> GAN</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q6. What does “unsupervised learning” refer to?</h3>
                <div class="options">
                    <label><input type="radio" name="q6" value="Learning from unlabeled data"> Learning from unlabeled data</label>
                    <label><input type="radio" name="q6" value="Learning from labeled data"> Learning from labeled data</label>
                    <label><input type="radio" name="q6" value="Learning with no data"> Learning with no data</label>
                    <label><input type="radio" name="q6" value="Learning in real time"> Learning in real time</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q7. Which algorithm is used to reduce dimensionality?</h3>
                <div class="options">
                    <label><input type="radio" name="q7" value="PCA"> PCA</label>
                    <label><input type="radio" name="q7" value="K‑Nearest Neighbors"> K‑Nearest Neighbors</label>
                    <label><input type="radio" name="q7" value="Naive Bayes"> Naive Bayes</label>
                    <label><input type="radio" name="q7" value="Decision Tree"> Decision Tree</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q8. What is “reinforcement learning”?</h3>
                <div class="options">
                    <label><input type="radio" name="q8" value="Learning by trial and error"> Learning by trial and error</label>
                    <label><input type="radio" name="q8" value="Learning from labeled data"> Learning from labeled data</label>
                    <label><input type="radio" name="q8" value="Learning with no feedback"> Learning with no feedback</label>
                    <label><input type="radio" name="q8" value="Learning using rules"> Learning using rules</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q9. Which metric measures the performance of a classification model?</h3>
                <div class="options">
                    <label><input type="radio" name="q9" value="Accuracy"> Accuracy</label>
                    <label><input type="radio" name="q9" value="Throughput"> Throughput</label>
                    <label><input type="radio" name="q9" value="Latency"> Latency</label>
                    <label><input type="radio" name="q9" value="Bandwidth"> Bandwidth</label>
                </div>
            </div>
            <div class="question-box">
                <h3>Q10. Which library is commonly used for machine learning in Python?</h3>
                <div class="options">
                    <label><input type="radio" name="q10" value="scikit-learn"> scikit-learn</label>
                    <label><input type="radio" name="q10" value="React"> React</label>
                    <label><input type="radio" name="q10" value="Express"> Express</label>
                    <label><input type="radio" name="q10" value="Laravel"> Laravel</label>
                </div>
            </div>
        <?php
        }
        ?>

        <button type="submit" class="submit-btn">Submit Exam</button>
    </form>

</div>

<script>
// 10-minute countdown timer
let time = 600;
let timer = setInterval(function() {
    let minutes = Math.floor(time / 60);
    let seconds = time % 60;
    document.getElementById("timer").innerText =
        minutes + ":" + (seconds < 10 ? "0" + seconds : seconds);
    time--;
    if (time < 0) {
        clearInterval(timer);
        alert("Time is up! Submitting your exam...");
        document.querySelector("form").submit();
    }
}, 1000);
</script>

<?php include("../includes/footer.php"); ?> 
