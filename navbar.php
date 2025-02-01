<?php
function renderNavbar() {
    echo <<<HTML

    
    <nav class="navbar">
        <div class="logo-container">
            <img src="uploads/eventura.png" alt="Company Logo" class="company-logo">
            <span class="logo-text">Eventura</span> 
        </div>
        <ul class="nav-links">
            <li><a href="index.php">Home</a></li>
            <li><a href="aboutus.php">About us</a></li>
            <li><a href="services.php">Services</a></li>   
            <li><a href="EventGallery.php">Event gallery</a></li>
            <li><a href="contactUs.php">Contact</a></li>
        </ul>
        <div class="auth-buttons">
            <a href="login.php"><button class="login">Log In</button></a>
            <a href="signup.php"><button class="signup">Sign Up</button></a>
        </div>
    </nav>
    HTML;
}
?>