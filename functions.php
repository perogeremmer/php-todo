<?php
require_once 'config.php';

function getAllTodos($statusFilter = null) {
    $pdo = getDbConnection();
    
    $sql = "SELECT * FROM todos";
    $params = [];
    
    if ($statusFilter && $statusFilter !== 'all') {
        $sql .= " WHERE status = ?";
        $params[] = $statusFilter;
    }
    
    $sql .= " ORDER BY created_at DESC";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    
    return $stmt->fetchAll();
}

function getTodoById($id) {
    $pdo = getDbConnection();
    
    $stmt = $pdo->prepare("SELECT * FROM todos WHERE id = ?");
    $stmt->execute([$id]);
    
    return $stmt->fetch();
}

function createTodo($title, $description = '', $status = 'pending', $priority = 'medium') {
    $pdo = getDbConnection();
    
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