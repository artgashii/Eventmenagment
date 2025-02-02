<?php
require_once 'config.php';
require_once 'navbar.php';
require_once 'footer.php';

$sql = "SELECT id, title, description, event_date, image_url FROM events";
$result = $conn->query($sql);

if ($result === false) {
    die("Error executing query: " . $conn->error);
}

$event_items = [];
if ($result->num_rows > 0) {
    while($row = $result->fetch_assoc()) {
        $event_items[] = $row;
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Gallery - Eventura</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php renderNavbar(); ?>

    <section class="event-gallery-container">
        <h2 class="section-heading">Our Event Gallery</h2>
        <p class="section-subheading">Explore Our Past and Upcoming Events</p>

        <div class="event-gallery-grid">
            <?php 
            if (empty($event_items)) {
                echo "<p>No events found.</p>";
            } else {
                foreach ($event_items as $item): 
            ?>
                <div class="event-gallery-card" onclick="window.location='event-details.php?id=<?php echo $item['id']; ?>'">
                    <img src="<?php echo !empty($item['image_url']) ? htmlspecialchars($item['image_url']) : '/placeholder.svg?height=300&width=400'; ?>" alt="<?php echo htmlspecialchars($item['title']); ?>">
                    <div class="event-gallery-info">
                        <h3><?php echo htmlspecialchars($item['title']); ?></h3>
                        <p><?php echo htmlspecialchars(substr($item['description'], 0, 100)) . '...'; ?></p>
                        <p>Date: <?php echo htmlspecialchars(date('F j, Y', strtotime($item['event_date']))); ?></p>
                    </div>
                </div>
            <?php 
                endforeach;
            }
            ?>
        </div>
    </section>

    <?php renderFooter(); ?>
</body>
</html>
