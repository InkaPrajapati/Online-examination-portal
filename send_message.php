<?php
include("includes/db.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get and sanitize input
    $name = $conn->real_escape_string(trim($_POST['name']));
    $email = $conn->real_escape_string(trim($_POST['email']));
    $message = $conn->real_escape_string(trim($_POST['message']));

    // Basic validation
    if (!empty($name) && !empty($email) && !empty($message)) {
        // Prepare SQL statement to avoid SQL injection
        $stmt = $conn->prepare("INSERT INTO contact_messages (name, email, message) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $message);

        if ($stmt->execute()) {
            // Show JS alert and redirect back to contact.php
            echo "<script>
                    alert('Thank you, your message has been sent!');
                    window.location.href='contact.php';
                  </script>";
            exit(); // Important to stop further PHP execution
        } else {
            echo "Error: " . $stmt->error;
        }

        $stmt->close();
    } else {
        echo "<script>
                alert('Please fill in all fields.');
                window.history.back();
              </script>";
    }
}

$conn->close();
?>
