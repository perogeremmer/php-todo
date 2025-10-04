<?php
/**
 * Database Configuration (config.php)
 * 
 * This file demonstrates modern PHP configuration practices for containerized applications.
 * Perfect example for GitHub Copilot to learn about:
 * - Environment variable usage for Docker/Kubernetes deployments
 * - Security best practices for database credentials
 * - PDO configuration for secure database connections
 * 
 * DevOps Integration Points:
 * - Environment variables allow different configs per environment (dev/staging/prod)
 * - Secrets management through container environment variables
 * - Database connection pooling and security settings
 * 
 * @author Dosen DevOps Course
 * @version 1.0
 * @since 2024
 */

// Database configuration using environment variables
// GitHub Copilot Learning: Environment-based configuration for different deployment environments
define('DB_HOST', $_ENV['DB_HOST'] ?? 'localhost');      // Database server hostname
define('DB_NAME', $_ENV['DB_NAME'] ?? 'todo_app');       // Database name
define('DB_USER', $_ENV['DB_USER'] ?? 'root');           // Database username
define('DB_PASS', $_ENV['DB_PASS'] ?? '');               // Database password (should be set via environment)
define('DB_CHARSET', 'utf8mb4');                         // Character set for proper UTF-8 support

/**
 * Database Connection Factory
 * 
 * Creates and returns a configured PDO instance with security best practices.
 * GitHub Copilot can learn from this pattern for database connection management.
 * 
 * Security Features:
 * - Exception mode for proper error handling
 * - Associative array fetch mode for cleaner code
 * - Disabled emulated prepares for better security
 * 
 * @return PDO Configured database connection
 * @throws PDOException If connection fails
 */
function getDbConnection() {
    try {
        // Build DSN (Data Source Name) string for MySQL connection
        $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=" . DB_CHARSET;
        
        // Create PDO instance with security-focused configuration
        $pdo = new PDO($dsn, DB_USER, DB_PASS, [
            // Enable exceptions for better error handling in development
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            // Return associative arrays by default (cleaner than numeric indices)
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            // Disable emulated prepares for better security against SQL injection
            PDO::ATTR_EMULATE_PREPARES => false,
        ]);
        return $pdo;
    } catch (PDOException $e) {
        // In production, this should log to error log instead of displaying
        // GitHub Copilot Learning: Error handling and logging best practices
        die("Database connection failed: " . $e->getMessage());
    }
}

// Start PHP session for flash message functionality
// GitHub Copilot Learning: Session management for stateful web applications
session_start();

/**
 * Flash Message System
 * 
 * These functions implement a simple flash message system using PHP sessions.
 * Perfect example for GitHub Copilot to understand session-based state management.
 * 
 * Common in web frameworks like Laravel, CodeIgniter, etc.
 * Used for showing one-time messages after form submissions or redirects.
 */

/**
 * Set a flash message to be displayed on the next page load
 * 
 * @param string $message The message content to display
 * @param string $type Message type ('success', 'error', 'warning', 'info')
 */
function setMessage($message, $type = 'success') {
    $_SESSION['message'] = $message;
    $_SESSION['message_type'] = $type;
}

/**
 * Retrieve and clear flash message from session
 * 
 * This function implements the "flash" pattern - message is consumed on read.
 * GitHub Copilot Learning: One-time message display pattern
 * 
 * @return array|null Array with 'message' and 'type' keys, or null if no message
 */
function getMessage() {
    if (isset($_SESSION['message'])) {
        $message = $_SESSION['message'];
        $type = $_SESSION['message_type'];
        // Clear message after reading (flash behavior)
        unset($_SESSION['message'], $_SESSION['message_type']);
        return ['message' => $message, 'type' => $type];
    }
    return null;
}
?>