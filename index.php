<?php
require_once 'functions.php';

$statusFilter = $_GET['status'] ?? 'all';
$todos = getAllTodos($statusFilter);
$message = getMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo List Application</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <h1 class="mb-4">Todo List Application</h1>
                
                <?php if ($message): ?>
                    <div class="alert alert-<?= $message['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                        <?= escape($message['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <!-- Add Todo Form -->
                <div class="card mb-4">
                    <div class="card-header">
                        <h5>Add New Todo</h5>
                    </div>
                    <div class="card-body">
                        <form action="actions/create.php" method="POST">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="mb-3">
                                        <label for="title" class="form-label">Title *</label>
                                        <input type="text" class="form-control" id="title" name="title" required maxlength="255">
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="priority" class="form-label">Priority</label>
                                        <select class="form-select" id="priority" name="priority">
                                            <option value="low">Low</option>
                                            <option value="medium" selected>Medium</option>
                                            <option value="high">High</option>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-3">
                                    <div class="mb-3">
                                        <label for="status" class="form-label">Status</label>
                                        <select class="form-select" id="status" name="status">
                                            <option value="pending" selected>Pending</option>
                                            <option value="in_progress">In Progress</option>
                                            <option value="completed">Completed</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <textarea class="form-control" id="description" name="description" rows="3" maxlength="5000"></textarea>
                            </div>
                            <button type="submit" class="btn btn-primary">Add Todo</button>
                        </form>
                    </div>
                </div>

                <!-- Filter Buttons -->
                <div class="mb-3">
                    <div class="btn-group" role="group">
                        <a href="?status=all" class="btn <?= $statusFilter === 'all' ? 'btn-primary' : 'btn-outline-primary' ?>">All</a>
                        <a href="?status=pending" class="btn <?= $statusFilter === 'pending' ? 'btn-primary' : 'btn-outline-primary' ?>">Pending</a>
                        <a href="?status=in_progress" class="btn <?= $statusFilter === 'in_progress' ? 'btn-primary' : 'btn-outline-primary' ?>">In Progress</a>
                        <a href="?status=completed" class="btn <?= $statusFilter === 'completed' ? 'btn-primary' : 'btn-outline-primary' ?>">Completed</a>
                    </div>
                </div>

                <!-- Todo List -->
                <div class="card">
                    <div class="card-header">
                        <h5>Todo List (<?= count($todos) ?> items)</h5>
                    </div>
                    <div class="card-body">
                        <?php if (empty($todos)): ?>
                            <div class="alert alert-info">
                                No todos found. <?= $statusFilter !== 'all' ? 'Try changing the filter or ' : '' ?>Add a new todo to get started!
                            </div>
                        <?php else: ?>
                            <div class="table-responsive">
                                <table class="table table-striped table-hover">
                                    <thead>
                                        <tr>
                                            <th>Title</th>
                                            <th>Status</th>
                                            <th>Priority</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($todos as $todo): ?>
                                            <tr>
                                                <td>
                                                    <strong><?= escape($todo['title']) ?></strong>
                                                    <?php if ($todo['description']): ?>
                                                        <br><small class="text-muted"><?= escape(substr($todo['description'], 0, 100)) ?><?= strlen($todo['description']) > 100 ? '...' : '' ?></small>
                                                    <?php endif; ?>
                                                </td>
                                                <td>
                                                    <span class="badge <?= getStatusBadgeClass($todo['status']) ?>">
                                                        <?= ucwords(str_replace('_', ' ', $todo['status'])) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <span class="badge <?= getPriorityBadgeClass($todo['priority']) ?>">
                                                        <?= ucfirst($todo['priority']) ?>
                                                    </span>
                                                </td>
                                                <td>
                                                    <small><?= formatDate($todo['created_at']) ?></small>
                                                </td>
                                                <td>
                                                    <div class="btn-group btn-group-sm" role="group">
                                                        <a href="detail.php?id=<?= $todo['id'] ?>" class="btn btn-outline-info">View</a>
                                                        <a href="detail.php?id=<?= $todo['id'] ?>&edit=1" class="btn btn-outline-warning">Edit</a>
                                                        <a href="actions/delete.php?id=<?= $todo['id'] ?>" class="btn btn-outline-danger" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</a>
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>