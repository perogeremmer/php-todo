<?php
require_once 'functions.php';

$id = $_GET['id'] ?? null;
$edit_mode = isset($_GET['edit']);

if (!$id) {
    setMessage('Todo not found', 'error');
    header('Location: index.php');
    exit;
}

$todo = getTodoById($id);

if (!$todo) {
    setMessage('Todo not found', 'error');
    header('Location: index.php');
    exit;
}

$message = getMessage();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Todo Detail - <?= escape($todo['title']) ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="assets/style.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-4">
        <div class="row">
            <div class="col-md-12">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="index.php">Todo List</a></li>
                        <li class="breadcrumb-item active">Todo Detail</li>
                    </ol>
                </nav>

                <?php if ($message): ?>
                    <div class="alert alert-<?= $message['type'] === 'success' ? 'success' : 'danger' ?> alert-dismissible fade show" role="alert">
                        <?= escape($message['message']) ?>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                <?php endif; ?>

                <div class="card">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5><?= $edit_mode ? 'Edit Todo' : 'Todo Detail' ?></h5>
                        <div>
                            <?php if (!$edit_mode): ?>
                                <a href="detail.php?id=<?= $todo['id'] ?>&edit=1" class="btn btn-warning btn-sm">Edit</a>
                            <?php endif; ?>
                            <a href="index.php" class="btn btn-secondary btn-sm">Back to List</a>
                        </div>
                    </div>
                    <div class="card-body">
                        <?php if ($edit_mode): ?>
                            <!-- Edit Form -->
                            <form action="actions/update.php" method="POST">
                                <input type="hidden" name="id" value="<?= $todo['id'] ?>">
                                
                                <div class="row">
                                    <div class="col-md-8">
                                        <div class="mb-3">
                                            <label for="title" class="form-label">Title *</label>
                                            <input type="text" class="form-control" id="title" name="title" value="<?= escape($todo['title']) ?>" required maxlength="255">
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="mb-3">
                                            <label for="priority" class="form-label">Priority</label>
                                            <select class="form-select" id="priority" name="priority">
                                                <option value="low" <?= $todo['priority'] === 'low' ? 'selected' : '' ?>>Low</option>
                                                <option value="medium" <?= $todo['priority'] === 'medium' ? 'selected' : '' ?>>Medium</option>
                                                <option value="high" <?= $todo['priority'] === 'high' ? 'selected' : '' ?>>High</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="status" class="form-label">Status</label>
                                    <select class="form-select" id="status" name="status">
                                        <option value="pending" <?= $todo['status'] === 'pending' ? 'selected' : '' ?>>Pending</option>
                                        <option value="in_progress" <?= $todo['status'] === 'in_progress' ? 'selected' : '' ?>>In Progress</option>
                                        <option value="completed" <?= $todo['status'] === 'completed' ? 'selected' : '' ?>>Completed</option>
                                    </select>
                                </div>

                                <div class="mb-3">
                                    <label for="description" class="form-label">Description</label>
                                    <textarea class="form-control" id="description" name="description" rows="5" maxlength="5000"><?= escape($todo['description']) ?></textarea>
                                </div>

                                <div class="d-flex gap-2">
                                    <button type="submit" class="btn btn-primary">Update Todo</button>
                                    <a href="detail.php?id=<?= $todo['id'] ?>" class="btn btn-secondary">Cancel</a>
                                    <a href="actions/delete.php?id=<?= $todo['id'] ?>" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this todo?')">Delete</a>
                                </div>
                            </form>
                        <?php else: ?>
                            <!-- View Mode -->
                            <div class="row">
                                <div class="col-md-8">
                                    <h4><?= escape($todo['title']) ?></h4>
                                    
                                    <?php if ($todo['description']): ?>
                                        <div class="mt-3">
                                            <h6>Description:</h6>
                                            <p class="text-muted"><?= nl2br(escape($todo['description'])) ?></p>
                                        </div>
                                    <?php endif; ?>
                                </div>
                                <div class="col-md-4">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="card-title">Todo Information</h6>
                                            
                                            <div class="mb-2">
                                                <strong>Status:</strong><br>
                                                <span class="badge <?= getStatusBadgeClass($todo['status']) ?>">
                                                    <?= ucwords(str_replace('_', ' ', $todo['status'])) ?>
                                                </span>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <strong>Priority:</strong><br>
                                                <span class="badge <?= getPriorityBadgeClass($todo['priority']) ?>">
                                                    <?= ucfirst($todo['priority']) ?>
                                                </span>
                                            </div>
                                            
                                            <div class="mb-2">
                                                <strong>Created:</strong><br>
                                                <small><?= formatDate($todo['created_at']) ?></small>
                                            </div>
                                            
                                            <?php if ($todo['updated_at'] !== $todo['created_at']): ?>
                                                <div class="mb-2">
                                                    <strong>Last Updated:</strong><br>
                                                    <small><?= formatDate($todo['updated_at']) ?></small>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
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