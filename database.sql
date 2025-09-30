-- Database Creation
CREATE DATABASE IF NOT EXISTS todo_app;
USE todo_app;

-- Table Creation
CREATE TABLE IF NOT EXISTS todos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(255) NOT NULL,
    description TEXT,
    status ENUM('pending', 'in_progress', 'completed') DEFAULT 'pending',
    priority ENUM('low', 'medium', 'high') DEFAULT 'medium',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_status (status),
    INDEX idx_priority (priority),
    INDEX idx_created_at (created_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- Sample Data (Optional)
INSERT INTO todos (title, description, status, priority) VALUES
('Learn Native PHP', 'Study basic concepts of PHP and MySQL', 'in_progress', 'high'),
('Setup Database', 'Create database and tables for the application', 'completed', 'high'),
('Implement CRUD', 'Implement Create, Read, Update, Delete functionality', 'pending', 'medium'),
('Test Application', 'Perform functionality testing of the application', 'pending', 'low');