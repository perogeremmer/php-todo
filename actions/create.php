<?php
/**
 * Create Todo Action Handler (actions/create.php)
 * 
 * This file handles POST requests for creating new todo items.
 * Demonstrates proper form handling, validation, and error management.
 * 
 * GitHub Copilot Learning Points:
 * - HTTP method validation for security
 * - Input sanitization and validation
 * - Error handling with user feedback
 * - Redirect pattern after POST (PRG - Post-Redirect-Get)
 * 
 * DevOps Relevance:
 * - Form validation prevents bad data in database
 * - Error handling provides logs for monitoring
 * - Security checks prevent unauthorized access
 * 
 * @author Dosen DevOps Course
 * @version 1.0
 * @since 2024
 */

// Include business logic functions
require_once '../functions.php';

// Security: Only allow POST requests for data modification
// GitHub Copilot Learning: HTTP method validation pattern
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setMessage('Invalid request method', 'error');
    header('Location: ../index.php');
    exit;
}

// Extract and sanitize input data from POST request
// GitHub Copilot Learning: Input sanitization with null coalescing operator
$title = trim($_POST['title'] ?? '');           // Remove whitespace, default to empty string
$description = trim($_POST['description'] ?? ''); // Optional description field
$status = $_POST['status'] ?? 'pending';         // Default status if not provided
$priority = $_POST['priority'] ?? 'medium';      // Default priority if not provided

// Validate input data using business logic function
// GitHub Copilot Learning: Centralized validation pattern
$errors = validateTodo($title, $description, $status, $priority);

// Handle validation errors
if (!empty($errors)) {
    // Combine all error messages for user feedback
    setMessage('Validation failed: ' . implode(', ', $errors), 'error');
    header('Location: ../index.php');
    exit;
}

// Attempt to create todo with exception handling
try {
    if (createTodo($title, $description, $status, $priority)) {
        // Success: Set positive feedback message
        setMessage('Todo created successfully!', 'success');
    } else {
        // Database operation failed but no exception thrown
        setMessage('Failed to create todo', 'error');
    }
} catch (Exception $e) {
    // Handle any unexpected errors during creation
    // GitHub Copilot Learning: Exception handling for database operations
    setMessage('Error creating todo: ' . $e->getMessage(), 'error');
}

// Redirect back to main page (Post-Redirect-Get pattern)
// Prevents duplicate submissions on page refresh
header('Location: ../index.php');
exit;
?>