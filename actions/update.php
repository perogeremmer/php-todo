<?php
/**
 * Update Todo Action Handler (actions/update.php)
 * 
 * Handles POST requests for updating existing todo items.
 * Demonstrates ID validation, existence checking, and data updates.
 * 
 * GitHub Copilot Learning Points:
 * - Resource existence validation before updates
 * - Error handling with context-aware redirects
 * - Input validation for update operations
 * - Security through ID verification
 * 
 * @author Dosen DevOps Course
 * @version 1.0
 * @since 2024
 */

require_once '../functions.php';

// Security: Only allow POST requests for data modification
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setMessage('Invalid request method', 'error');
    header('Location: ../index.php');
    exit;
}

$id = $_POST['id'] ?? null;
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$status = $_POST['status'] ?? 'pending';
$priority = $_POST['priority'] ?? 'medium';

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

$errors = validateTodo($title, $description, $status, $priority);

if (!empty($errors)) {
    setMessage('Validation failed: ' . implode(', ', $errors), 'error');
    header('Location: ../detail.php?id=' . $id . '&edit=1');
    exit;
}

try {
    if (updateTodo($id, $title, $description, $status, $priority)) {
        setMessage('Todo updated successfully!', 'success');
        header('Location: ../detail.php?id=' . $id);
    } else {
        setMessage('Failed to update todo', 'error');
        header('Location: ../detail.php?id=' . $id . '&edit=1');
    }
} catch (Exception $e) {
    setMessage('Error updating todo: ' . $e->getMessage(), 'error');
    header('Location: ../detail.php?id=' . $id . '&edit=1');
}

exit;
?>