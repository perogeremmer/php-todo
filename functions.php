<?php
/**
 * Business Logic Functions (functions.php)
 * 
 * This file contains all the core business logic for the Todo application.
 * Demonstrates clean separation of concerns and reusable function design.
 * 
 * GitHub Copilot Learning Objectives:
 * - CRUD operations with prepared statements (security)
 * - Input validation and sanitization
 * - Helper functions for UI components
 * - Error handling and data validation patterns
 * 
 * DevOps Relevance:
 * - Database operations that can be monitored and logged
 * - Validation functions that prevent application errors
 * - Utility functions for consistent data formatting
 * 
 * @author Dosen DevOps Course
 * @version 1.0
 * @since 2024
 */

// Include database configuration and connection functions
require_once 'config.php';

/**
 * Retrieve all todos with optional status filtering
 * 
 * This function demonstrates dynamic query building with prepared statements.
 * GitHub Copilot Learning: Safe parameter binding prevents SQL injection.
 * 
 * @param string|null $statusFilter Filter by status ('pending', 'in_progress', 'completed', 'all', or null)
 * @return array Array of todo items from database
 */
function getAllTodos($statusFilter = null) {
    $pdo = getDbConnection();
    
    // Base SQL query
    $sql = "SELECT * FROM todos";
    $params = [];
    
    // Conditional WHERE clause for filtering
    // GitHub Copilot Learning: Dynamic query building pattern
    if ($statusFilter && $statusFilter !== 'all') {
        $sql .= " WHERE status = ?";
        $params[] = $statusFilter;
    }
    
    // Always order by newest first
    $sql .= " ORDER BY created_at DESC";
    
    // Use prepared statements for security
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll();
}

/**
 * Retrieve a single todo by its ID
 * 
 * @param int $id The todo ID to retrieve
 * @return array|false Todo data array or false if not found
 */
function getTodoById($id) {
    $pdo = getDbConnection();
    
    // Prepared statement prevents SQL injection
    $stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ?");
    $stmt->execute([$id]);
    
    // fetch() returns single row or false if not found
    return $stmt->fetch();
}

/**
 * Create a new todo item
 * 
 * GitHub Copilot Learning: INSERT operation with default parameter values
 * 
 * @param string $title Todo title (required)
 * @param string $description Todo description (optional)
 * @param string $status Initial status (default: 'pending')
 * @param string $priority Priority level (default: 'medium')
 * @return bool True on success, false on failure
 */
function createTodo($title, $description = '', $status = 'pending', $priority = 'medium') {
    $pdo = getDbConnection();
    
    // INSERT with prepared statement for security
    $stmt = $pdo->prepare("INSERT INTO todos (title, description, status, priority) VALUES (?, ?, ?, ?)");
    return $stmt->execute([$title, $description, $status, $priority]);
}

function updateTodo($id, $title, $description = '', $status = 'pending', $priority = 'medium') {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("UPDATE todos SET title = ?, description = ?, status = ?, priority = ?, updated_at = CURRENT_TIMESTAMP WHERE id = ?");
    return $stmt->execute([$title, $description, $status, $priority, $id]);
}

function deleteTodo($id) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("DELETE FROM todos WHERE id = ?");
    return $stmt->execute([$id]);
}

function validateTodo($title, $description = '', $status = 'pending', $priority = 'medium') {
    $errors = [];
    
    if (empty(trim($title))) {
        $errors[] = "Title is required";
    } elseif (strlen($title) > 255) {
        $errors[] = "Title must be less than 255 characters";
    }
    
    if (strlen($description) > 5000) {
        $errors[] = "Description must be less than 5000 characters";
    }
    
    $validStatuses = ['pending', 'in_progress', 'completed'];
    if (!in_array($status, $validStatuses)) {
        $errors[] = "Invalid status";
    }
    
    $validPriorities = ['low', 'medium', 'high'];
    if (!in_array($priority, $validPriorities)) {
        $errors[] = "Invalid priority";
    }
    
    return $errors;
}

function getStatusBadgeClass($status) {
    switch ($status) {
        case 'pending':
            return 'badge-secondary';
        case 'in_progress':
            return 'badge-primary';
        case 'completed':
            return 'badge-success';
        default:
            return 'badge-secondary';
    }
}

function getPriorityBadgeClass($priority) {
    switch ($priority) {
        case 'low':
            return 'badge-success';
        case 'medium':
            return 'badge-warning';
        case 'high':
            return 'badge-danger';
        default:
            return 'badge-warning';
    }
}

function formatDate($date) {
    return date('M j, Y g:i A', strtotime($date));
}

function escape($string) {
    return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
}
?>