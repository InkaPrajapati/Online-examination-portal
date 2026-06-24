<?php include("../includes/header.php"); ?>

<style>
/* ====== PAGE STYLING ====== */
.exam-page {
    padding: 40px 5%;
    background: #f7f9fc;
}

.exam-page h2 {
    text-align: center;
    font-size: 32px;
    margin-bottom: 30px;
    color: #333;
}

/* ====== GRID STYLING ====== */
.exam-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 25px;
}

.exam-card {
    background: #fff;
    border-radius: 10px;
    overflow: hidden;
    box-shadow: 0px 4px 10px rgba(0,0,0,0.1);
    text-align: center;
    transition: 0.3s;
}

.exam-card:hover {
    transform: translateY(-5px);
}

.exam-card img {
    width: 100%;
    height: 180px;
    object-fit: cover;
}

.exam-card h3 {
    padding: 15px 10px 5px;
    font-size: 22px;
    color: #222;
}

.exam-card p {
    color: #666;
    padding: 5px 15px 15px;
}

.exam-btn {
    display: inline-block;
    background: #2a73ff;
    color: #fff;
    padding: 10px 18px;
    margin-bottom: 15px;
    text-decoration: none;
    border-radius: 5px;
    font-weight: bold;
    transition: 0.2s;
}

.exam-btn:hover {
    background: #0050d4;
}
</style>

<section class="exam-page">
    <h2>Available Exams</h2>

    <div class="exam-grid">

        <!-- C Programming -->
        <div class="exam-card">
			<img src="/online-exam-portal/assets/images/c.jpg" alt="C Programming">
            <h3>C Programming</h3>
            <p>Basic to advanced C language examination.</p>
            <a href="exam_page.php?subject=c" class="exam-btn">View Exam</a>
        </div>

        <!-- C++ -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/cpp.jpg" alt="C++ Programming">
            <h3>C++ Programming</h3>
            <p>Object-oriented concepts and problem solving.</p>
            <a href="exam_page.php?subject=cpp" class="exam-btn">View Exam</a>
        </div>

        <!-- Java -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/java.jpg" alt="Java Programming">
            <h3>Java Programming</h3>
            <p>Learn and test core Java concepts.</p>
            <a href="exam_page.php?subject=java" class="exam-btn">View Exam</a>
        </div>

        <!-- JavaScript -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/javascript.jpg" alt="JavaScript">
            <h3>JavaScript</h3>
            <p>Test your frontend scripting knowledge.</p>
            <a href="exam_page.php?subject=javascript" class="exam-btn">View Exam</a>
        </div>

        <!-- Python -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/python.jpeg" alt="C++ Programming">
            <h3>Python</h3>
            <p>Python basics, OOP, and advanced topics.</p>
            <a href="exam_page.php?subject=python" class="exam-btn">View Exam</a>
        </div>

        <!-- Cyber Security -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/cyber.jpg" alt="Cyber Security">
            <h3>Cyber Security</h3>
            <p>Security fundamentals and ethical hacking.</p>
            <a href="exam_page.php?subject=cyber" class="exam-btn">View Exam</a>
        </div>

        <!-- PHP Framework -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/php_framework.jpg" alt="PHP Framework">
            <h3>PHP Framework</h3>
            <p>Laravel / CodeIgniter framework examination.</p>
            <a href="exam_page.php?subject=php_framework" class="exam-btn">View Exam</a>
        </div>

        <!-- Graphics -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/graphic_design.jpeg" alt="Graphics">
            <h3>Graphics</h3>
            <p>Designing, tools, and visualization concepts.</p>
            <a href="exam_page.php?subject=graphics" class="exam-btn">View Exam</a>
        </div>

        <!-- Digital Marketing -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/digital_marketing.png" alt="Digital Marketing">
            <h3>Digital Marketing</h3>
            <p>SEO, SEM, SMM and marketing concepts.</p>
            <a href="exam_page.php?subject=digital_marketing" class="exam-btn">View Exam</a>
        </div>

        <!-- AI / ML -->
        <div class="exam-card">
            <img src="/online-exam-portal/assets/images/ai_ml.jpg" alt="AI & Machine Learning">
            <h3>AI & Machine Learning</h3>
            <p>AI fundamentals, ML algorithms, and applications.</p>
            <a href="exam_page.php?subject=ai_ml" class="exam-btn">View Exam</a>
        </div>

    </div>
</section>

<?php include("../includes/footer.php"); ?>
