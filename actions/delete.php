<?php
/**
 * Delete Todo Action Handler (actions/delete.php)
 * 
 * Handles deletion of todo items via GET or POST requests.
 * Demonstrates safe deletion with existence validation.
 * 
 * GitHub Copilot Learning Points:
 * - Resource validation before deletion
 * - Flexible parameter handling (GET/POST)
 * - Error handling for missing resources
 * - Safe deletion patterns
 * 
 * DevOps Relevance:
 * - Data integrity through validation
 * - Audit trail through error messages
 * - Safe deletion prevents orphaned references
 * 
 * @author Dosen DevOps Course
 * @version 1.0
 * @since 2024
 */

require_once '../functions.php';

// Accept ID from either GET or POST request
// GitHub Copilot Learning: Flexible parameter handling for different request methods
$id = $_GET['id'] ?? $_POST['id'] ?? null;

// Validate that an ID was provided
if (!$id) {
    setMessage('Todo ID is required', 'error');
    header('Location: ../index.php');
    exit;
}

$existingTodo = getTodoById($id);
if (!$existingTodo) {
    setMessage('Todo not found', 'error');
    header('Location: ../index.php');
    exit;
}

try {
    if (deleteTodo($id)) {
        setMessage('Todo deleted successfully!', 'success');
    } else {
        setMessage('Failed to delete todo', 'error');
    }
} catch (Exception $e) {
    setMessage('Error deleting todo: ' . $e->getMessage(), 'error');
}

header('Location: ../index.php');
exit;
?>