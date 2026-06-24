<?php
session_start();

// Only admin allowed
if (!isset($_SESSION['admin_id'])) {
    header("Location: ../auth/login.php");
    exit();
}

include("../includes/header.php");
require_once $_SERVER['DOCUMENT_ROOT'] . '/online-exam-portal/config/db.php';


// Fetch all students including status
$query = "SELECT id AS student_id, name, email, enrollment, created_at, status FROM students ORDER BY id ASC";
$result = $conn->query($query);
?>

<div class="content-wrapper">
    <div class="manage-students-container">

        <h2>Manage Students</h2>
        <p>Below is the list of all registered students.</p>

        <table class="students-table">
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Email</th>
                <th>Enrollment</th>
                <th>Registered On</th>
                <th>Status</th>
                <th>Action</th>
            </tr>

            <?php if ($result && $result->num_rows > 0): ?>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?php echo $row['student_id']; ?></td>
                        <td><?php echo htmlspecialchars($row['name']); ?></td>
                        <td><?php echo htmlspecialchars($row['email']); ?></td>
                        <td><?php echo $row['enrollment']; ?></td>
                        <td><?php echo $row['created_at']; ?></td>

                        <!-- STATUS -->
                        <td>
                            <?php if ($row['status'] == 1): ?>
                                <span style="color: green; font-weight: bold;">Active</span>
                            <?php else: ?>
                                <span style="color: red; font-weight: bold;">Deactive</span>
                            <?php endif; ?>
                        </td>

                        <!-- ACTION BUTTONS -->
                        <td>

                            <!-- DELETE BUTTON -->
                            <a href="delete_student.php?id=<?php echo $row['student_id']; ?>"
                               onclick="return confirm('Delete this student?');"
                               class="delete-btn">
                               Delete
                            </a>
                            <br><br>

                            <!-- ACTIVATE / DEACTIVATE BUTTON -->
                            <?php if ($row['status'] == 1): ?>
                                <a href="toggle_student.php?id=<?php echo $row['student_id']; ?>&status=0"
                                   onclick="return confirm('Deactivate this student?');"
                                   class="deactivate-btn"
                                   style="color:white; background:red; padding:5px 10px; border-radius:4px; text-decoration:none;">
                                   Deactivate
                                </a>
                            <?php else: ?>
                                <a href="toggle_student.php?id=<?php echo $row['student_id']; ?>&status=1"
                                   onclick="return confirm('Activate this student?');"
                                   class="activate-btn"
                                   style="color:white; background:green; padding:5px 10px; border-radius:4px; text-decoration:none;">
                                   Activate
                                </a>
                            <?php endif; ?>

                        </td>
                    </tr>
                <?php endwhile; ?>

            <?php else: ?>
                <tr>
                    <td colspan="7" style="text-align:center;">No students found</td>
                </tr>
            <?php endif; ?>

        </table>

    </div>
</div>

<?php include("../includes/footer.php"); ?>