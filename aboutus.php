<?php
require_once 'navbar.php';
require_once 'footer.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Eventura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php renderNavbar(); ?>

    <section class="hero">
        <h1>About Eventura</h1>
        <p>Your trusted partner in crafting unforgettable events.</p>
    </section>

    <section class="about-content" style="padding: 2rem; text-align: center;">
        <div style="max-width: 800px; margin: 0 auto;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #333;">Who We Are</h2>
            <p style="font-size: 1.2rem; color: #555; line-height: 1.8;">
                At Eventura, we believe every event has a story to tell. Whether it's a corporate summit, a wedding, or a cultural festival, our mission is to bring your vision to life with precision and creativity. 
                With a passionate team of event professionals and cutting-edge tools, we offer seamless planning and execution for events of all sizes.
            </p>
        </div>

        <div style="max-width: 800px; margin: 2rem auto;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #333;">Our Vision</h2>
            <p style="font-size: 1.2rem; color: #555; line-height: 1.8;">
                We envision a world where every occasion, big or small, is celebrated with joy and elegance. By merging technology with creativity, we aim to redefine the art of event management.
            </p>
        </div>

        <div style="max-width: 800px; margin: 2rem auto;">
            <h2 style="font-size: 2rem; margin-bottom: 1rem; color: #333;">Why Choose Us?</h2>
            <ul  style="list-style: none; padding: 0; font-size: 1.2rem; color: #555; line-height: 1.8;">
                <li> End-to-end event planning solutions</li>
                <li> Personalized services tailored to your needs</li>
                <li> Experienced professionals with a passion for excellence</li>
                <li> Transparent pricing and flexible packages</li>
                <li> A commitment to making every event unique and memorable</li>
            </ul>
        </div>
    </section>

    <?php renderFooter(); ?>
</body>
</html>