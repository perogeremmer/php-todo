<?php
require_once '../functions.php';

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    setMessage('Invalid request method', 'error');
    header('Location: ../index.php');
    exit;
}

$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');
$status = $_POST['status'] ?? 'pending';
$priority = $_POST['priority'] ?? 'medium';

$errors = validateTodo($title, $description, $status, $priority);

if (!empty($errors)) {
    setMessage('Validation failed: ' . implode(', ', $errors), 'error');
    header('Location: ../index.php');
    exit;
}

try {
    if (createTodo($title, $description, $status, $priority)) {
        setMessage('Todo created successfully!', 'success');
    } else {
        setMessage('Failed to create todo', 'error');
    }
} catch (Exception $e) {
    setMessage('Error creating todo: ' . $e->getMessage(), 'error');
}

header('Location: ../index.php');
exit;
?>