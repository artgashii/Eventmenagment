<?php
require_once 'config.php';

function sanitizeInput($input) {
    return htmlspecialchars(strip_tags(trim($input)));
}

function createUser($conn, $name, $email, $password, $role = 'user') {
    $name = sanitizeInput($name);
    $email = sanitizeInput($email);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    $sql = "INSERT INTO users (name, email, password, role) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $role);
    
    return $stmt->execute();
}

function getUserByEmail($conn, $email) {
    $email = sanitizeInput($email);
    
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function getAllUsers($conn) {
    $sql = "SELECT * FROM users ORDER BY name ASC";
    $result = $conn->query($sql);
    
    $users = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $users[] = $row;
        }
    }
    
    return $users;
}

function updateUser($conn, $id, $name, $email, $role) {
    $id = intval($id);
    $name = sanitizeInput($name);
    $email = sanitizeInput($email);
    $role = sanitizeInput($role);
    
    $sql = "UPDATE users SET name = ?, email = ?, role = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssi", $name, $email, $role, $id);
    
    return $stmt->execute();
}

function deleteUser($conn, $id) {
    $id = intval($id);
    
    $sql = "DELETE FROM users WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function createEvent($conn, $title, $description, $event_date, $end_date, $location, $category_id, $capacity, $price, $created_by, $image) {
    $title = sanitizeInput($title);
    $description = sanitizeInput($description);
    $location = sanitizeInput($location);
    $category_id = intval($category_id);
    $capacity = intval($capacity);
    $price = floatval($price);
    $created_by = intval($created_by);
    
    $target_dir = "uploads/";
    $target_file = $target_dir . basename($image["name"]);
    $imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
    
    $check = getimagesize($image["tmp_name"]);
    if($check === false) {
        return false;
    }
    
    if ($image["size"] > 5000000) {
        return false;
    }
    
    if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif" ) {
        return false;
    }
    
    if (move_uploaded_file($image["tmp_name"], $target_file)) {
        $sql = "INSERT INTO events (title, description, event_date, end_date, location, category_id, capacity, price, created_by, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sssssiidis", $title, $description, $event_date, $end_date, $location, $category_id, $capacity, $price, $created_by, $target_file);
        
        return $stmt->execute();
    } else {
        return false;
    }
}

function getAllEvents($conn) {
    $sql = "SELECT e.*, c.name as category_name FROM events e LEFT JOIN event_categories c ON e.category_id = c.id ORDER BY e.event_date DESC";
    $result = $conn->query($sql);
    
    $events = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $events[] = $row;
        }
    }
    
    return $events;
}

function getEventById($conn, $id) {
    $id = intval($id);
    
    $sql = "SELECT e.*, c.name as category_name FROM events e LEFT JOIN event_categories c ON e.category_id = c.id WHERE e.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateEvent($conn, $id, $title, $description, $event_date, $end_date, $location, $category_id, $capacity, $price) {
    $id = intval($id);
    $title = sanitizeInput($title);
    $description = sanitizeInput($description);
    $location = sanitizeInput($location);
    $category_id = intval($category_id);
    $capacity = intval($capacity);
    $price = floatval($price);
    
    $sql = "UPDATE events SET title = ?, description = ?, event_date = ?, end_date = ?, location = ?, category_id = ?, capacity = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("sssssiiidi", $title, $description, $event_date, $end_date, $location, $category_id, $capacity, $price, $id);
    
    return $stmt->execute();
}

function deleteEvent($conn, $id) {
    $id = intval($id);
    
    $sql = "DELETE FROM events WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function createCategory($conn, $name, $description) {
    $name = sanitizeInput($name);
    $description = sanitizeInput($description);
    
    $sql = "INSERT INTO event_categories (name, description) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $name, $description);
    
    return $stmt->execute();
}

function getAllCategories($conn) {
    $sql = "SELECT * FROM event_categories ORDER BY name ASC";
    $result = $conn->query($sql);
    
    $categories = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $categories[] = $row;
        }
    }
    
    return $categories;
}

function getCategoryById($conn, $id) {
    $id = intval($id);
    
    $sql = "SELECT * FROM event_categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateCategory($conn, $id, $name, $description) {
    $id = intval($id);
    $name = sanitizeInput($name);
    $description = sanitizeInput($description);
    
    $sql = "UPDATE event_categories SET name = ?, description = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $name, $description, $id);
    
    return $stmt->execute();
}

function deleteCategory($conn, $id) {
    $id = intval($id);
    
    $sql = "DELETE FROM event_categories WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}

function createTicket($conn, $user_id, $event_id, $ticket_type, $price) {
    $user_id = intval($user_id);
    $event_id = intval($event_id);
    $ticket_type = sanitizeInput($ticket_type);
    $price = floatval($price);
    
    $sql = "INSERT INTO tickets (user_id, event_id, ticket_type, price) VALUES (?, ?, ?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisd", $user_id, $event_id, $ticket_type, $price);
    
    return $stmt->execute();
}

function getAllTickets($conn) {
    $sql = "SELECT t.*, u.name as user_name, e.title as event_title FROM tickets t 
            LEFT JOIN users u ON t.user_id = u.id 
            LEFT JOIN events e ON t.event_id = e.id 
            ORDER BY t.id DESC";
    $result = $conn->query($sql);
    
    $tickets = [];
    if ($result) {
        while ($row = $result->fetch_assoc()) {
            $tickets[] = $row;
        }
    }
    
    return $tickets;
}

function getTicketById($conn, $id) {
    $id = intval($id);
    
    $sql = "SELECT t.*, u.name as user_name, e.title as event_title FROM tickets t 
            LEFT JOIN users u ON t.user_id = u.id 
            LEFT JOIN events e ON t.event_id = e.id 
            WHERE t.id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    
    $result = $stmt->get_result();
    return $result->fetch_assoc();
}

function updateTicket($conn, $id, $user_id, $event_id, $ticket_type, $price) {
    $id = intval($id);
    $user_id = intval($user_id);
    $event_id = intval($event_id);
    $ticket_type = sanitizeInput($ticket_type);
    $price = floatval($price);
    
    $sql = "UPDATE tickets SET user_id = ?, event_id = ?, ticket_type = ?, price = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("iisdi", $user_id, $event_id, $ticket_type, $price, $id);
    
    return $stmt->execute();
}

function deleteTicket($conn, $id) {
    $id = intval($id);
    
    $sql = "DELETE FROM tickets WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $id);
    
    return $stmt->execute();
}
?>

