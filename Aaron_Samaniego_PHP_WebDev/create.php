PHP
<?php

require_once 'config.php';

$message = "";
$message_type = "";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');

    if (!empty($name) && filter_var($email, FILTER_VALIDATE_EMAIL)) {
        try {
            $stmt = $conn->prepare("INSERT INTO users (name, email) VALUES (?, ?)");
            $stmt->bind_param("ss", $name, $email);
            $stmt->execute();
            $stmt->close();

            header("Location: read.php?message=created");
            exit;
        } catch (mysqli_sql_exception $e) {
            if ($e->getCode() == 1062) {
                $message = "That email address is already registered.";
            } else {
                $message = "An error occurred while registering the user.";
            }
            $message_type = "danger";
        }
    } else {
        $message = "Please enter a valid name and email address.";
        $message_type = "danger";
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register User</title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
</head>

<body class="bg-light">

    <nav class="navbar navbar-dark bg-primary">
        <div class="container">
            <a class="navbar-brand" href="index.php">User Registration System</a>
            <div>
                <a href="index.php" class="btn btn-light btn-sm">Home</a>
                <a href="read.php" class="btn btn-outline-light btn-sm">View Users</a>
            </div>
        </div>
    </nav>

    <div class="container py-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card shadow">
                    <div class="card-body">
                        <h1 class="h3">Register User</h1>
                        <p class="text-muted">Enter the user's information below.</p>

                        <?php if ($message): ?>
                            <div class="alert alert-<?= htmlspecialchars($message_type) ?>">
                                <?= htmlspecialchars($message) ?>
                            </div>
                        <?php endif; ?>

                        <form method="POST">
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name</label>
                                <input type="text" id="name" name="name" class="form-control" placeholder="Enter full name" required>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">Email Address</label>
                                <input type="email" id="email" name="email" class="form-control" placeholder="Enter email address" required>
                            </div>

                            <button type="submit" class="btn btn-primary">Register User</button>
                            <a href="read.php" class="btn btn-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

</body>

</html>