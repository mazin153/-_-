CREATE DATABASE sind_org CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE sind_org;
CREATE TABLE users (
 id INT AUTO_INCREMENT PRIMARY KEY,
 full_name VARCHAR(150) NOT NULL,
 phone VARCHAR(30) NOT NULL,
 email VARCHAR(150) NOT NULL UNIQUE,
 password VARCHAR(255) NOT NULL,
 state VARCHAR(100),
 profession VARCHAR(100),
 volunteer_field VARCHAR(150),
 role ENUM('member','admin') DEFAULT 'member',
 status ENUM('active','inactive') DEFAULT 'active',
 created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);
