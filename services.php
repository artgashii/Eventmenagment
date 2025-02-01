<?php
require_once 'navbar.php';
require_once 'footer.php';

$services = [
    [
        'icon' => 'wedding-icon.png',
        'title' => 'Wedding Coordination',
        'description' => 'Create unforgettable moments on your special day with our comprehensive wedding planning services. From timeline creation to vendor management, we ensure every detail is perfect.'
    ],
    [
        'icon' => 'corporate-icon.png',
        'title' => 'Corporate Events',
        'description' => 'Professional event management for business conferences, seminars, and team building activities. We handle logistics, scheduling, and coordination for successful corporate gatherings.'
    ],
    [
        'icon' => 'birthday-icon.png',
        'title' => 'Birthday Planning',
        'description' => 'Make your celebration extraordinary with our birthday planning services. We create personalized experiences that reflect your style and preferences.'
    ],
    [
        'icon' => 'social-icon.png',
        'title' => 'Social Gatherings',
        'description' => 'From intimate dinner parties to large social events, we coordinate every aspect to ensure your gathering is memorable and runs smoothly.'
    ],
    [
        'icon' => 'entertainment-icon.png',
        'title' => 'Entertainment Event',
        'description' => 'Create spectacular entertainment events with our expert planning and coordination. We handle everything from venue selection to performer management.'
    ],
    [
        'icon' => 'fundraising-icon.png',
        'title' => 'Fundraising Events',
        'description' => 'Organize impactful fundraising events that help you reach your goals. We manage donor relations, logistics, and create engaging experiences.'
    ]
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Services - Eventura</title>
    <link rel="stylesheet" href="style.css">
    <style>
        .why-choose ul {
            list-style-position: inside;
            padding-left: 0;
        }
        .why-choose li {
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
    <?php renderNavbar(); ?>

    <section class="services">
        <h2 class="services-heading">Our Services</h2>
        <p class="services-subheading">We Craft Memories For You</p>
        
        <div class="services-grid">
            <?php foreach ($services as $service): ?>
            <div class="service-card">
                <img src="uploads/<?php echo htmlspecialchars($service['icon']); ?>" alt="<?php echo htmlspecialchars($service['title']); ?> Icon">
                <h3><?php echo htmlspecialchars($service['title']); ?></h3>
                <p><?php echo htmlspecialchars($service['description']); ?></p>
                <a href="#" class="details-btn">See Details ></a>
            </div>
            <?php endforeach; ?>
        </div>

        <div class="why-choose">
            <h3>Why Choose Our Services?</h3>
            <ul>
                <li>Experienced professionals with a passion for excellence</li>
                <li>Transparent pricing and flexible packages</li>
                <li>A commitment to making every event unique and memorable</li>
            </ul>
        </div>
    </section>

    <?php renderFooter(); ?>
</body>
</html>