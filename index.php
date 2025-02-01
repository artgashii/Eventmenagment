<?php
require_once 'navbar.php';
require_once 'footer.php';

$events = [
    [
        'name' => 'Serene Soundscape Soiree',
        'description' => 'Experience the harmony of serene melodies and vibrant vibes in our Soundscape Soiree.',
        'image' => 'uploads/serene-soundscape.jpg',
    ],
    [
        'name' => 'FutureTech Expo Hub',
        'description' => 'Dive into the future with cutting-edge innovations and interactive exhibits.',
        'image' => 'uploads/futuretech-expo.jpg',
    ],
    [
        'name' => 'Nature\'s Palette Showcase',
        'description' => 'Celebrate the beauty of nature with colors, flavors, and captivating moments.',
        'image' => 'uploads/nature-palette.jpg',
    ],
    [
        'name' => 'World Flavors Adventure',
        'description' => 'Embark on a culinary journey that spans cultures and continents.',
        'image' => 'uploads/world-flavors.jpg',
    ],
];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Eventura Homepage</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>

    <?php renderNavbar(); ?>
    
    <section class="hero">
        <h1>Transforming Occasions Into Great Memories</h1>
        <p>We specialize in turning ordinary occasions into extraordinary moments that stay in your heart forever. We infuse every celebration with magic.</p>
        <div class="hero-buttons">
            <button class="primary-btn">Book Your Event</button>
            <button class="secondary-btn">How it works</button>
        </div>
    </section>

    <section class="event-slider">
        <div class="slider">
            <?php foreach ($events as $event): ?>
            <div class="slide">
                <img src="<?php echo $event['image']; ?>" alt="<?php echo $event['name']; ?>">
                <div class="slide-info">
                    <h3 class="event-name"><?php echo $event['name']; ?></h3>
                    <p class="event-description"><?php echo $event['description']; ?></p>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
        <button class="prev-btn">&lt;</button>
        <button class="next-btn">&gt;</button>
    </section>

    <section class="about-us">
        <div class="about-content">
            <div class="about-text">
                <h2>We Craft Memories For You</h2>
                <p>At Eventura, we believe every event has a story to tell. Whether it's a corporate summit, a wedding, or a cultural festival, our mission is to bring your vision to life with precision and creativity. With a passionate team of event professionals and cutting-edge tools, we offer seamless planning and execution for events of all sizes.</p>
                <ul>
                    <li>Our designers and planners collaborate to bring uniqueness.</li>
                    <li>A team of seasoned creative minds.</li>
                </ul>
                <div class="about-buttons">
                    <button class="primary-btn">Book Your Event</button>
                    <button class="secondary-btn">Watch Video</button>
                </div>
            </div>
            <div class="about-image">
                <img src="uploads/event-image.jpg" alt="Event Image">
            </div>
        </section>

        <section class="services">
            <div class="container">
                <h2 class="services-heading">Our Services</h2>
                <p class="services-subheading">We Craft Memories For You</p>
                <div class="services-grid">
                    <div class="service-card">
                        <h3>Wedding Coordination</h3>
                        <p>Timeline creation and management for the entire wedding day.</p>
                        <a href="#" class="details-btn">See Details ></a>
                    </div>
        
                    <div class="service-card">
                        <h3>Corporate Events</h3>
                        <p>Timeline creation and management for the entire corporate event.</p>
                        <a href="#" class="details-btn">See Details ></a>
                    </div>
                    
                    <div class="service-card">
                        <h3>Birthday Planning</h3>
                        <p>Timeline creation and management for the entire birthday event.</p>
                        <a href="#" class="details-btn">See Details ></a>
                    </div>
        
                    <div class="service-card">
                        <h3>Social Gatherings</h3>
                        <p>Timeline creation and management for the entire gathering event.</p>
                        <a href="#" class="details-btn">See Details ></a>
                    </div>
        
                    <div class="service-card">
                        <h3>Entertainment Event</h3>
                        <p>Timeline creation and management for the Entertainment event.</p>
                        <a href="#" class="details-btn">See Details ></a>
                    </div>
        
                    <div class="service-card">
                        <h3>Fundraising Events</h3>
                        <p>Timeline creation and management for the Fundraising event.</p>
                        <a href="#" class="details-btn">See Details ></a>
                    </div>
                </div>
            </div>
        </section>  

        <section class="gallery">
            <div class="container">
                <h2 class="gallery-heading">Our Portfolio Of Celebrations</h2>
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="uploads/party-event1.jpg" alt="Party Event 1">
                    </div>
                    <div class="gallery-item">
                        <img src="uploads/party-event2.jpg" alt="Party Event 2">
                    </div>
                    <div class="gallery-item">
                        <img src="uploads/fireworks-event.jpg" alt="Fireworks Event">
                    </div>
                    <div class="gallery-item">
                        <img src="uploads/corporate-event.jpg" alt="Corporate Event">
                    </div>
                    <div class="gallery-item">
                        <img src="uploads/cocktail-party.jpg" alt="Cocktail Party">
                    </div>
                    <div class="gallery-item">
                        <img src="uploads/crowd-celebration.jpg" alt="Crowd Celebration">
                    </div>
                </div>
                <a href="#" class="see-all-btn">See All Events</a>
            </div>
        </section>    

        <section class="testimonials">
            <h2 class="section-title">What Our User Says</h2>
            <h3 class="portfolio-title">Our Portfolio Of Celebrations</h3>
            <div class="carousel">
                <div class="carousel-item">
                    <div class="testimonial-card">
                        <div class="rating">
                            ★★★★★
                        </div>
                        <h4>John Kinsley</h4>
                        <p class="role">Corporate Event</p>
                        <p class="testimonial-text">Amazing team! They turned our idea into a perfect event. Highly recommend!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial-card">
                        <div class="rating">
                            ★★★★★
                        </div>
                        <h4>Sabrina Cole</h4>
                        <p class="role">Bachelor Party</p>
                        <p class="testimonial-text">Best party ever! Creative setup and seamless organization. Thank you, Eventura!</p>
                    </div>
                </div>
                <div class="carousel-item">
                    <div class="testimonial-card">
                        <div class="rating">
                            ★★★★★
                        </div>
                        <h4>Gordon Ramsey</h4>
                        <p class="role">Cooking Event</p>
                        <p class="testimonial-text">Eventura handled everything for our event seamlessly – from booking the venue to managing the timeline. Their organization and expertise took all the stress off our shoulders, letting us just enjoy the event. Highly recommended!</p>
                    </div>
                </div>
            </div>
        </section>

        <section class="contact">
            <h2 class="contact-title">Contact Us</h2>
            <h3 class="contact-subtitle">Book Your Extraordinary Event Now</h3>
            <p>Share your phone number with us, and we'll promptly reach out to provide you with a personalized event management schedule.</p>
            <form class="contact-form">
                <input type="tel" placeholder="Enter your phone number" required>
                <button type="submit" class="send-btn">Send →</button>
            </form>
        </section>   

    <?php renderFooter(); ?>

    <script src="index.js"></script>
</body>
</html>



