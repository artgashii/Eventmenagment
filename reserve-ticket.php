<?php
session_start();
require_once 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $event_id = isset($_POST['event_id']) ? intval($_POST['event_id']) : 0;
    
    // In a real application, you would get the user_id from the session after they log in
    // For now, we'll use a placeholder user_id
    $user_id = 1; // Placeholder user ID
    
    // Get the event price
    $price_query = "SELECT price FROM events WHERE id = ?";
    $price_stmt = $conn->prepare($price_query);
    $price_stmt->bind_param("i", $event_id);
    $price_stmt->execute();
    $price_result = $price_stmt->get_result();
    $event_price = $price_result->fetch_assoc()['price'];
    $price_stmt->close();

    // Insert reservation into database
    $sql = "INSERT INTO tickets (user_id, event_id, ticket_type, price) VALUES (?, ?, 'standard', ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iid", $user_id, $event_id, $event_price);
    
    if ($stmt->execute()) {
        $_SESSION['message'] = "Ticket reserved successfully!";
    } else {
        $_SESSION['message'] = "Error reserving ticket: " . $stmt->error;
    }
    
    $stmt->close();
}

// Redirect back to the event details page
header("Location: event-details.php?id=" . $event_id);
exit();
?>

