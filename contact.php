<?php 
include("includes/header.php"); 
?>

<div class="content-wrapper">
    <div class="register-container"> <!-- using same style as login/register -->
        <h2>Get in Touch</h2>
        <p>If you have questions, feedback, or need help, feel free to message us.</p>

        <form action="send_message.php" method="POST" class="reg-form"> <!-- same form style -->
            <label>Your Name</label>
            <input type="text" name="name" required placeholder="Enter your name">

            <label>Your Email</label>
            <input type="email" name="email" required placeholder="Enter your email">

            <label>Message</label>
            <textarea name="message" rows="5" required placeholder="Type your message here..."></textarea>

            <input type="submit" class="reg-btn" value="Send Message">
        </form>
    </div>
</div>

<?php 
include("includes/footer.php"); 
?>
