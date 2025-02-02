<?php
session_start();
require_once 'config.php';
require_once 'navbar.php';
require_once 'footer.php';

// Get event ID from URL parameter
$event_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

// Fetch event details from the database
$sql = "SELECT e.*, ec.name as category_name 
        FROM events e 
        LEFT JOIN event_categories ec ON e.category_id = ec.id 
        WHERE e.id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $event_id);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $event = $result->fetch_assoc();
} else {
    // Redirect to gallery if event not found
    header("Location: EventGallery.php");
    exit();
}

$stmt->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($event['title']); ?> - Eventura</title>
    <link rel="stylesheet" href="event-details.css">
    <link rel="stylesheet" href="style.css">
</head>
<body> 
    <?php renderNavbar(); ?>

    <section class="event-details-container">
        <h2 class="section-heading"><?php echo htmlspecialchars($event['title']); ?></h2>
        <div class="event-details">
            <img src="<?php echo !empty($event['image_url']) ? htmlspecialchars($event['image_url']) : '/placeholder.svg?height=400&width=600'; ?>" alt="<?php echo htmlspecialchars($event['title']); ?>" class="event-image">
            <div class="event-info">
                <p><strong>Date:</strong> <?php echo date('F j, Y g:i A', strtotime($event['event_date'])); ?></p>
                <?php if (!empty($event['end_date'])): ?>
                    <p><strong>End Date:</strong> <?php echo date('F j, Y g:i A', strtotime($event['end_date'])); ?></p>
                <?php endif; ?>
                <p><strong>Location:</strong> <?php echo htmlspecialchars($event['location']); ?></p>
                <p><strong>Category:</strong> <?php echo htmlspecialchars($event['category_name']); ?></p>
                <p><strong>Description:</strong> <?php echo nl2br(htmlspecialchars($event['description'])); ?></p>
                <p><strong>Price:</strong> $<?php echo number_format($event['price'], 2); ?></p>
                <p><strong>Capacity:</strong> <?php echo $event['capacity']; ?> attendees</p>
                <form action="reserve-ticket.php" method="POST">
                    <input type="hidden" name="event_id" value="<?php echo $event['id']; ?>">
                    <button type="submit" class="buy-ticket-btn">Reserve Ticket</button>
                </form>
            </div>
        </div>
    </section>
   
    <?php renderFooter(); ?>
</body>
</html>