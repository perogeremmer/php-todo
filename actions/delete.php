<?php
require_once '../functions.php';

$id = $_GET['id'] ?? $_POST['id'] ?? null;

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