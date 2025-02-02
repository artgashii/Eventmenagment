<?php
require_once 'navbar.php';
require_once 'footer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Contact Us - Eventura</title>
    <link rel="stylesheet" href="contactUs.css">
</head>
<body>

    <?php renderNavbar(); ?>

    <section class="contact-section">
        <h2>Contact Us</h2>
        <p>If you have any questions or would like to work with us, feel free to reach out!</p>
        <form action="contactUs.php" method="POST" class="contact-form">
            <div class="form-group">
                <label for="name">Full Name:</label>
                <input type="text" id="name" name="name" placeholder="Your Name" required>
                <div class="error-message" id="name-error"></div>
            </div>
            <div class="form-group">
                <label for="email">Email Address:</label>
                <input type="email" id="email" name="email" placeholder="Your Email" required>
                <div class="error-message" id="email-error"></div>
            </div>
            <div class="form-group">
                <label for="message">Message:</label>
                <textarea id="message" name="message" rows="5" placeholder="Your Message" required></textarea>
                <div class="error-message" id="message-error"></div>
            </div>
            <button type="submit" class="submit-btn">Send Message</button>
        </form>
    </section>

    <?php renderFooter(); ?>

<script src="contactUs.js"></script>

</body>
</html>