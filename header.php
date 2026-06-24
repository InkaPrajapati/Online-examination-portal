<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Online Exam Portal</title>
<link rel="stylesheet" href="/online-exam-portal/assets/css/style.css">
<style>
    .students-table th:last-child,
    .students-table tb:last-child {
        width: 120px;
        white-space: nowrap;
    }
    .page-container {
    max-width: 1500px;
    margin: 0 auto;
    padding: 40px;
}

.table-responsive {
    width: 100%;
    overflow-x: auto;
}

table {
    width: 100%;
    border-collapse: collapse;
    table-layout:fixed;
}

td.email-col {
              white-space: normal;
              word-break: normal;
}

td.name-col {
                white-space: normal;
                word-break: break-word;
}

td.action-col{
      white-space: nowrap;
}   

th, td {
    padding: 12px;
    text-align: left;
    vertical-align: middle;
    white-space:normal;
    word-break:break-word;
}

th {
    background: #007bff;
    color: white;
}
    td.action-col{

        white-space: nowrap;
    }
    </style>
</head>

<body>
<div class="content-wrapper">

<!-- ================= NAVBAR ================= -->
<nav class="navbar">
    <div class="nav-left">
        <h2 class="logo">
            <a href="/online-exam-portal/index.php" class="logo-link">Online Exam Portal
            </a>
        </h2>
    </div>

    <ul class="nav-links">
        <?php if (isset($_SESSION['student_id'])): ?>

            <li><a href="/online-exam-portal/student/dashboard.php">Dashboard</a></li>
            <li><a href="/online-exam-portal/student/take_exam.php">Exams</a></li>
            <li><a href="/online-exam-portal/student/results.php">Results</a></li>
            <li style="color:#ff6600; font-weight:bold;"><?php echo $_SESSION['student_name']; ?></li>
            <li><a href="/online-exam-portal/auth/logout.php"> Logout</a></li>

        <?php elseif (isset($_SESSION['admin_id'])): ?>

            <li><a href="/online-exam-portal/admin/dashboard.php">Dashboard</a></li>
            <li><a href="/online-exam-portal/admin/create_exam.php">Create Exam</a></li>
            <li><a href="/online-exam-portal/admin/manage_students.php">Students</a></li>
            <li style="color:#00aaff; font-weight:bold;"><?php echo $_SESSION['admin_name']; ?></li>
            <li><a href="/online-exam-portal/auth/logout.php">Logout</a></li>

        <?php else: ?>

            <li><a href="/online-exam-portal/index.php">Home</a></li>
            <li><a href="/online-exam-portal/auth/student_login.php">Login</a></li>
            <li><a href="/online-exam-portal/contact.php">Contact</a></li>
            <li><a href="/online-exam-portal/about.php">About</a></li>

        <?php endif; ?>
    </ul>
</nav>
