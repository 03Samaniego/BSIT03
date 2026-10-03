<?php

require_once 'config.php';

try {
    $result = $conn->query(
        "SELECT id, name, email, created_at
         FROM users
         ORDER BY id DESC"
    );

    $users = $result->fetch_all(MYSQLI_ASSOC);
    $result->free();
} catch (mysqli_sql_exception $e) {
    die("Could not retrieve users from the database.");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registered Users</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">User Registration System</a>
            <div>
                <a href="index.php" class="btn btn-light btn-sm">Home</a>
                <a href="create.php" class="btn btn-outline-light btn-sm">Register User</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">

        <div class="d-flex justify-content-between align-items-center mb-4">
            <div>
                <h1 class="h2">Registered Users</h1>
                <p class="text-muted">Users currently stored in the database.</p>
            </div>
            <a href="create.php" class="btn btn-primary">+ Register User</a>
        </div>

        <?php if (isset($_GET['message']) && $_GET['message'] === 'created'): ?>
            <div class="alert alert-success">User registered successfully.</div>
        <?php elseif (isset($_GET['message']) && $_GET['message'] === 'updated'): ?>
            <div class="alert alert-success">User updated successfully.</div>
        <?php elseif (isset($_GET['message']) && $_GET['message'] === 'deleted'): ?>
            <div class="alert alert-success">User deleted successfully.</div>
        <?php endif; ?>

        <div class="card shadow">
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped table-hover">
                        <thead class="table-primary">
                            <tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Created At</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (!empty($users)): ?>
                                <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td><?= htmlspecialchars($user['id']) ?></td>
                                        <td><?= htmlspecialchars($user['name']) ?></td>
                                        <td><?= htmlspecialchars($user['email']) ?></td>
                                        <td><?= htmlspecialchars($user['created_at']) ?></td>
                                        <td>
                                            <a href="update.php?id=<?= $user['id'] ?>" class="btn btn-warning btn-sm">Edit</a>
                                            <a href="delete.php?id=<?= $user['id'] ?>" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure you want to delete this user?');">Delete</a>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" class="text-center">No users found.</td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>

</body>

</html>