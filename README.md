This is an Event Management site.

To run the code, please execute the following MySQL queries to create the database and insert some information into the database:

CREATE DATABASE eventura;
USE eventura;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
role ENUM('user', 'admin') DEFAULT 'user',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE event_categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL UNIQUE,
description TEXT
);

CREATE TABLE events (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
description TEXT,
event_date DATETIME NOT NULL,
end_date DATETIME,
location VARCHAR(255),
capacity INT NOT NULL CHECK (capacity > 0),
price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
image_url VARCHAR(500),
category_id INT,
created_by INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
FOREIGN KEY (category_id) REFERENCES event_categories(id) ON DELETE SET NULL
);

CREATE TABLE tickets (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
event_id INT NOT NULL,
ticket_type ENUM('standard', 'vip', 'early_bird') DEFAULT 'standard',
price DECIMAL(10, 2) NOT NULL,
purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

DELIMITER //
CREATE TRIGGER check_event_capacity BEFORE INSERT ON tickets
FOR EACH ROW
BEGIN
DECLARE current_tickets INT;
DECLARE max_capacity INT;

    SELECT COUNT(*) INTO current_tickets FROM tickets WHERE event_id = NEW.event_id;
    SELECT capacity INTO max_capacity FROM events WHERE id = NEW.event_id;

    IF current_tickets >= max_capacity THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Event is fully booked';
    END IF;

END;
//
DELIMITER ;

CREATE DATABASE eventura;
USE eventura;

CREATE TABLE users (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL,
email VARCHAR(100) UNIQUE NOT NULL,
password VARCHAR(255) NOT NULL,
role ENUM('user', 'admin') DEFAULT 'user',
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

CREATE TABLE event_categories (
id INT AUTO_INCREMENT PRIMARY KEY,
name VARCHAR(100) NOT NULL UNIQUE,
description TEXT
);

CREATE TABLE events (
id INT AUTO_INCREMENT PRIMARY KEY,
title VARCHAR(255) NOT NULL,
description TEXT,
event_date DATETIME NOT NULL,
end_date DATETIME,
location VARCHAR(255),
capacity INT NOT NULL CHECK (capacity > 0),
price DECIMAL(10, 2) NOT NULL DEFAULT 0.00,
image_url VARCHAR(500),
category_id INT,
created_by INT,
created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
FOREIGN KEY (created_by) REFERENCES users(id) ON DELETE SET NULL,
FOREIGN KEY (category_id) REFERENCES event_categories(id) ON DELETE SET NULL
);

CREATE TABLE tickets (
id INT AUTO_INCREMENT PRIMARY KEY,
user_id INT NOT NULL,
event_id INT NOT NULL,
ticket_type ENUM('standard', 'vip', 'early_bird') DEFAULT 'standard',
price DECIMAL(10, 2) NOT NULL,
purchased_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
FOREIGN KEY (event_id) REFERENCES events(id) ON DELETE CASCADE
);

DELIMITER //
CREATE TRIGGER check_event_capacity BEFORE INSERT ON tickets
FOR EACH ROW
BEGIN
DECLARE current_tickets INT;
DECLARE max_capacity INT;

    SELECT COUNT(*) INTO current_tickets FROM tickets WHERE event_id = NEW.event_id;
    SELECT capacity INTO max_capacity FROM events WHERE id = NEW.event_id;

    IF current_tickets >= max_capacity THEN
        SIGNAL SQLSTATE '45000'
        SET MESSAGE_TEXT = 'Event is fully booked';
    END IF;

END;
//
DELIMITER ;

INSERT INTO users (name, email, password, role) VALUES
('Admin User', 'admin@eventura.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin'),
('John Doe', 'john@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user'),
('Jane Smith', 'jane123@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'user');

INSERT INTO event_categories (name, description) VALUES
('Rock Concert', 'Live performances by rock bands'),
('Pop Concert', 'Live performances by pop artists'),
('Classical Concert', 'Orchestral and chamber music performances'),
('Jazz Concert', 'Live jazz music performances');

INSERT INTO events (title, description, event_date, end_date, location, capacity, price, image_url, category_id, created_by) VALUES
('Rock Revolution', 'Experience the ultimate rock concert featuring top bands', '2023-08-15 19:00:00', '2023-08-15 23:00:00', 'City Arena, Prishtina', 5000, 50.00, 'uploads/1_cdf2019.webp', 1, 1),
('Pop Extravaganza', 'A night of chart-topping pop hits', '2023-09-01 20:00:00', '2023-09-01 23:30:00', 'National Stadium, Prishtina', 10000, 75.00, 'uploads/1_DF75yh_qcMYphKB8eiQ68g.jpg', 2, 1),
('Classical Nights', 'An evening of timeless classical masterpieces', '2023-09-15 18:30:00', '2023-09-15 21:00:00', 'National Theater, Prishtina', 1000, 100.00, 'uploads/1_DF75yh_qcMYphKB8eiQ68g.jpg', 3, 1),
('Jazz in the Park', 'Smooth jazz under the stars', '2023-08-30 19:30:00', '2023-08-30 22:30:00', 'City Park, Prishtina', 2000, 30.00, 'uploads/JoeCreate22Infra-07497.jpeg', 4, 1),
('Indie Rock Showcase', 'Discover the best up-and-coming rock bands', '2023-10-05 20:00:00', '2023-10-05 23:00:00', 'Underground Club, Prishtina', 500, 25.00, 'uploads/JoeCreate22Infra-07497.jpeg', 1, 1),
('Summer Pop Fest', 'The biggest pop music festival of the summer', '2023-07-20 14:00:00', '2023-07-20 23:00:00', 'Sunny Beach, Durres', 15000, 90.00, 'uploads/orange-county-nightlife-clubbing-near-me-costa-mesa-ca-1-1024x576.webp', 2, 1);

INSERT INTO tickets (user_id, event_id, ticket_type, price) VALUES
(2, 1, 'standard', 50.00),
(2, 3, 'vip', 150.00),
(3, 2, 'early_bird', 60.00),
(3, 4, 'standard', 30.00),
(2, 5, 'standard', 25.00),
(3, 6, 'vip', 120.00);
