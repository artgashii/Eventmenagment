<?php
session_start();
require_once 'config.php';
require_once 'functions.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

set_error_handler('handleError');
set_exception_handler('handleException');


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (!isset($_POST['csrf_token']) || !validateCSRFToken($_POST['csrf_token'])) {
        sendJsonResponse(['error' => 'Invalid CSRF token'], 403);
    }
}


if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_role']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: login.php");
    exit();
}


if (!isset($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}

$admin_name = $_SESSION['user_name'] ?? 'Admin';

if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['action'])) {
    $action = $_GET['action'];

    switch ($action) {
        case 'get_dashboard':
            $data = [
                'users_count' => count(getAllUsers($conn)),
                'events_count' => count(getAllEvents($conn)),
                'categories_count' => count(getAllCategories($conn)),
                'tickets_count' => count(getAllTickets($conn))
            ];
            sendJsonResponse($data);
            break;

        case 'get_users':
            $users = getAllUsers($conn);
            sendJsonResponse($users);
            break;

        case 'get_events':
            $events = getAllEvents($conn);
            sendJsonResponse($events);
            break;

        case 'get_categories':
            $categories = getAllCategories($conn);
            sendJsonResponse($categories);
            break;

        case 'get_tickets':
            $tickets = getAllTickets($conn);
            sendJsonResponse($tickets);
            break;
        case 'get_user':
            if (isset($_GET['id'])) {
                $user = getUserById($conn, $_GET['id']);
                sendJsonResponse($user);
            }
            break;

        case 'get_event':
            if (isset($_GET['id'])) {
                $event = getEventById($conn, $_GET['id']);
                sendJsonResponse($event);
            }
            break;

        case 'get_category':
            if (isset($_GET['id'])) {
                $category = getCategoryById($conn, $_GET['id']);
                sendJsonResponse($category);
            }
            break;
        case 'get_ticket':
            if (isset($_GET['id'])) {
                $ticket = getTicketById($conn, $_GET['id']);
                sendJsonResponse($ticket);
            }
            break;

        default:
            sendJsonResponse(['error' => 'Invalid action'], 400);
            break;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? '';

    if (!validateCSRFToken($_POST['csrf_token'] ?? '')) {
        sendJsonResponse(['success' => false, 'message' => 'Invalid CSRF token'], 403);
        exit;
    }

    switch ($action) {
        case 'add_user':
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';
            $role = $_POST['role'] ?? 'user';

            if (createUser($conn, $name, $email, $password, $role)) {
                sendJsonResponse(['success' => true]);
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Error creating user'], 400);
            }
            break;

        case 'edit_user':
            $id = $_POST['id'] ?? '';
            $name = $_POST['name'] ?? '';
            $email = $_POST['email'] ?? '';
            $role = $_POST['role'] ?? '';

            if (updateUser($conn, $id, $name, $email, $role)) {
                sendJsonResponse(['success' => true]);
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Error updating user'], 400);
            }
            break;

        case 'delete_user':
            $id = $_POST['id'] ?? '';

            if (deleteUser($conn, $id)) {
                sendJsonResponse(['success' => true]);
            } else {
                sendJsonResponse(['success' => false, 'message' => 'Error deleting user'], 400);
            }
            break;
        case 'add_event':
            break;
        case 'edit_event':
            break;
        case 'delete_event':
            break;
        case 'add_category':
            break;
        case 'edit_category':
            break;
        case 'delete_category':
            break;
        case 'add_ticket':
            break;
        case 'edit_ticket':
            break;
        case 'delete_ticket':
            break;
        default:
            sendJsonResponse(['error' => 'Invalid action'], 400);
            break;
    }
}

function handleError($errno, $errstr, $errfile, $errline) {
    $error = [
        'error' => [
            'message' => $errstr,
            'type' => $errno,
            'file' => $errfile,
            'line' => $errline
        ]
    ];
    sendJsonResponse($error, 500);
}

function handleException($e) {
    $error = [
        'error' => [
            'message' => $e->getMessage(),
            'type' => get_class($e),
            'file' => $e->getFile(),
            'line' => $e->getLine()
        ]
    ];
    sendJsonResponse($error, 500);
}

function sendJsonResponse($data, $statusCode = 200) {
    http_response_code($statusCode);
    header('Content-Type: application/json');
    echo json_encode($data);
    exit;
}

function validateCSRFToken($token) {
    return isset($_SESSION['csrf_token']) && hash_equals($_SESSION['csrf_token'], $token);
}

$users = getAllUsers($conn);
$events = getAllEvents($conn);
$categories = getAllCategories($conn);
$tickets = getAllTickets($conn);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <title>Admin Dashboard - Eventura</title>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="admin-dashboard.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <style>
        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.4);
        }
        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 500px;
        }
        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
            cursor: pointer;
        }
        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body class="admin-body">
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <img src="uploads/eventura.png" alt="Eventura Logo" class="admin-logo-img">
                <span>Admin Panel</span>
            </div>
            
            <nav class="admin-nav">
                <ul>
                    <li class="active" data-section="dashboard">
                        <i class="fas fa-home"></i>Dashboard
                    </li>
                    <li data-section="users">
                        <i class="fas fa-users"></i>User Management
                    </li>
                    <li data-section="events">
                        <i class="fas fa-calendar"></i>Events
                    </li>
                    <li data-section="categories">
                        <i class="fas fa-tags"></i>Categories
                    </li>
                    <li data-section="tickets">
                        <i class="fas fa-ticket-alt"></i>Tickets
                    </li>
                    <li data-section="settings">
                        <i class="fas fa-cog"></i>Settings
                    </li>
                </ul>
            </nav>
    
            <div class="admin-profile">
                <img src="uploads/admin-avatar.png" alt="Admin Avatar" class="admin-avatar">
                <div class="admin-info">
                    <span class="admin-name"><?php echo htmlspecialchars($admin_name); ?></span>
                    <a href="logout.php" class="admin-logout">Logout</a>
                </div>
            </div>
        </aside>
    
        <main class="admin-main">
            <header class="admin-header">
                <div class="admin-search">
                    <input type="text" placeholder="Search...">
                </div>
                <div class="admin-actions">
                    <button class="admin-notification">
                        <i class="fas fa-bell"></i>
                        <span class="notification-badge">3</span>
                    </button>
                    <button class="admin-settings">
                        <i class="fas fa-cog"></i>
                    </button>
                </div>
            </header>
    
            <div class="admin-content">
                <section id="dashboard" class="admin-section active">
                    <h2>Dashboard Overview</h2>
                    <div class="admin-stats">
                        <div class="stat-card">
                            <h3>Total Users</h3>
                            <p class="stat-number"><?php echo count($users); ?></p>
                        </div>
                        <div class="stat-card">
                            <h3>Active Events</h3>
                            <p class="stat-number"><?php echo count($events); ?></p>
                        </div>
                        <div class="stat-card">
                            <h3>Categories</h3>
                            <p class="stat-number"><?php echo count($categories); ?></p>
                        </div>
                        <div class="stat-card">
                            <h3>Tickets Sold</h3>
                            <p class="stat-number"><?php echo count($tickets); ?></p>
                        </div>
                    </div>
                </section>

                <section id="users" class="admin-section">
                    <h2>User Management</h2>
                    <div class="admin-actions-bar">
                        <button class="admin-btn" onclick="showModal('add-user')">Add New User</button>
                    </div>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($user['id']); ?></td>
                                    <td><?php echo htmlspecialchars($user['name']); ?></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['role']); ?></td>
                                    <td>
                                        <button class="edit-user" data-id="<?php echo $user['id']; ?>">Edit</button>
                                        <button class="delete-user" data-id="<?php echo $user['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="events" class="admin-section">
                    <h2>Events Management</h2>
                    <div class="admin-actions-bar">
                        <button class="admin-btn" onclick="showModal('add-event')">Add New Event</button>
                    </div>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Title</th>
                                    <th>Date</th>
                                    <th>Location</th>
                                    <th>Category</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($events as $event): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($event['id']); ?></td>
                                    <td><?php echo htmlspecialchars($event['title']); ?></td>
                                    <td><?php echo htmlspecialchars($event['event_date']); ?></td>
                                    <td><?php echo htmlspecialchars($event['location']); ?></td>
                                    <td><?php echo htmlspecialchars($event['category_name']); ?></td>
                                    <td>
                                        <button class="edit-event" data-id="<?php echo $event['id']; ?>">Edit</button>
                                        <button class="delete-event" data-id="<?php echo $event['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="categories" class="admin-section">
                    <h2>Categories Management</h2>
                    <div class="admin-actions-bar">
                        <button class="admin-btn" onclick="showModal('add-category')">Add New Category</button>
                    </div>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($categories as $category): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($category['id']); ?></td>
                                    <td><?php echo htmlspecialchars($category['name']); ?></td>
                                    <td><?php echo htmlspecialchars($category['description']); ?></td>
                                    <td>
                                        <button class="edit-category" data-id="<?php echo $category['id']; ?>">Edit</button>
                                        <button class="delete-category" data-id="<?php echo $category['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>

                <section id="tickets" class="admin-section">
                    <h2>Tickets Management</h2>
                    <div class="admin-actions-bar">
                        <button class="admin-btn" onclick="showModal('add-ticket')">Add New Ticket</button>
                    </div>
                    <div class="admin-table-container">
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>User</th>
                                    <th>Event</th>
                                    <th>Type</th>
                                    <th>Price</th>
                                    <th>Purchased At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($tickets as $ticket): ?>
                                <tr>
                                    <td><?php echo htmlspecialchars($ticket['id']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['user_name']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['event_title']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['ticket_type']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['price']); ?></td>
                                    <td><?php echo htmlspecialchars($ticket['purchased_at']); ?></td>
                                    <td>
                                        <button class="edit-ticket" data-id="<?php echo $ticket['id']; ?>">Edit</button>
                                        <button class="delete-ticket" data-id="<?php echo $ticket['id']; ?>">Delete</button>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </section>
            </div>
        </main>
    </div>

    <div id="add-user" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New User</h2>
            <form id="add-user-form">
                <input type="hidden" name="action" value="add_user">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label for="user-name">Name:</label>
                    <input type="text" id="user-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="user-email">Email:</label>
                    <input type="email" id="user-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="user-password">Password:</label>
                    <input type="password" id="user-password" name="password" required>
                </div>
                <div class="form-group">
                    <label for="user-role">Role:</label>
                    <select id="user-role" name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Add User</button>
            </form>
        </div>
    </div>

    <div id="edit-user" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit User</h2>
            <form id="edit-user-form">
                <input type="hidden" name="action" value="edit_user">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" id="edit-user-id" name="id">
                <div class="form-group">
                    <label for="edit-user-name">Name:</label>
                    <input type="text" id="edit-user-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="edit-user-email">Email:</label>
                    <input type="email" id="edit-user-email" name="email" required>
                </div>
                <div class="form-group">
                    <label for="edit-user-role">Role:</label>
                    <select id="edit-user-role" name="role">
                        <option value="user">User</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>
                <button type="submit">Update User</button>
            </form>
        </div>
    </div>

    <div id="add-event" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Event</h2>
            <form id="add-event-form">
                <input type="hidden" name="action" value="add_event">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label for="event-title">Title:</label>
                    <input type="text" id="event-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="event-description">Description:</label>
                    <textarea id="event-description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="event-date">Event Date:</label>
                    <input type="datetime-local" id="event-date" name="event_date" required>
                </div>
                <div class="form-group">
                    <label for="event-end-date">End Date:</label>
                    <input type="datetime-local" id="event-end-date" name="end_date">
                </div>
                <div class="form-group">
                    <label for="event-location">Location:</label>
                    <input type="text" id="event-location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="event-capacity">Capacity:</label>
                    <input type="number" id="event-capacity" name="capacity" required>
                </div>
                <div class="form-group">
                    <label for="event-price">Price:</label>
                    <input type="number" id="event-price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="event-category">Category:</label>
                    <select id="event-category" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="event-image">Image:</label>
                    <input type="file" id="event-image" name="image" accept="image/*" required>
                </div>
                <button type="submit">Add Event</button>
            </form>
        </div>
    </div>

    <div id="edit-event" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Event</h2>
            <form id="edit-event-form">
                <input type="hidden" name="action" value="edit_event">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" id="edit-event-id" name="id">
                <div class="form-group">
                    <label for="edit-event-title">Title:</label>
                    <input type="text" id="edit-event-title" name="title" required>
                </div>
                <div class="form-group">
                    <label for="edit-event-description">Description:</label>
                    <textarea id="edit-event-description" name="description" required></textarea>
                </div>
                <div class="form-group">
                    <label for="edit-event-date">Event Date:</label>
                    <input type="datetime-local" id="edit-event-date" name="event_date" required>
                </div>
                <div class="form-group">
                    <label for="edit-event-end-date">End Date:</label>
                    <input type="datetime-local" id="edit-event-end-date" name="end_date">
                </div>
                <div class="form-group">
                    <label for="edit-event-location">Location:</label>
                    <input type="text" id="edit-event-location" name="location" required>
                </div>
                <div class="form-group">
                    <label for="edit-event-capacity">Capacity:</label>
                    <input type="number" id="edit-event-capacity" name="capacity" required>
                </div>
                <div class="form-group">
                    <label for="edit-event-price">Price:</label>
                    <input type="number" id="edit-event-price" name="price" step="0.01" required>
                </div>
                <div class="form-group">
                    <label for="edit-event-category">Category:</label>
                    <select id="edit-event-category" name="category_id" required>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?php echo $category['id']; ?>"><?php echo htmlspecialchars($category['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <button type="submit">Update Event</button>
            </form>
        </div>
    </div>

    <div id="add-category" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Category</h2>
            <form id="add-category-form">
                <input type="hidden" name="action" value="add_category">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label for="category-name">Name:</label>
                    <input type="text" id="category-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="category-description">Description:</label>
                    <textarea id="category-description" name="description"></textarea>
                </div>
                <button type="submit">Add Category</button>
            </form>
        </div>
    </div>

    <div id="edit-category" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Category</h2>
            <form id="edit-category-form">
                <input type="hidden" name="action" value="edit_category">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" id="edit-category-id" name="id">
                <div class="form-group">
                    <label for="edit-category-name">Name:</label>
                    <input type="text" id="edit-category-name" name="name" required>
                </div>
                <div class="form-group">
                    <label for="edit-category-description">Description:</label>
                    <textarea id="edit-category-description" name="description"></textarea>
                </div>
                <button type="submit">Update Category</button>
            </form>
        </div>
    </div>

    <div id="add-ticket" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Add New Ticket</h2>
            <form id="add-ticket-form">
                <input type="hidden" name="action" value="add_ticket">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <div class="form-group">
                    <label for="ticket-user">User:</label>
                    <select id="ticket-user" name="user_id" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ticket-event">Event:</label>
                    <select id="ticket-event" name="event_id" required>
                        <?php foreach ($events as $event): ?>
                            <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ticket-type">Type:</label>
                    <select id="ticket-type" name="ticket_type">
                        <option value="standard">Standard</option>
                        <option value="vip">VIP</option>
                        <option value="early_bird">Early Bird</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="ticket-price">Price:</label>
                    <input type="number" id="ticket-price" name="price" step="0.01" required>
                </div>
                <button type="submit">Add Ticket</button>
            </form>
        </div>
    </div>

    <div id="edit-ticket" class="modal">
        <div class="modal-content">
            <span class="close">&times;</span>
            <h2>Edit Ticket</h2>
            <form id="edit-ticket-form">
                <input type="hidden" name="action" value="edit_ticket">
                <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                <input type="hidden" id="edit-ticket-id" name="id">
                <div class="form-group">
                    <label for="edit-ticket-user">User:</label>
                    <select id="edit-ticket-user" name="user_id" required>
                        <?php foreach ($users as $user): ?>
                            <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['name']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-ticket-event">Event:</label>
                    <select id="edit-ticket-event" name="event_id" required>
                        <?php foreach ($events as $event): ?>
                            <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['title']); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-ticket-type">Type:</label>
                    <select id="edit-ticket-type" name="ticket_type">
                        <option value="standard">Standard</option>
                        <option value="vip">VIP</option>
                        <option value="early_bird">Early Bird</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="edit-ticket-price">Price:</label>
                    <input type="number" id="edit-ticket-price" name="price" step="0.01" required>
                </div>
                <button type="submit">Update Ticket</button>
            </form>
        </div>
    </div>

    <script src="admin-dashboard.js"></script>
</body>
</html>

