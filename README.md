DATABASE SCHEMA

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
