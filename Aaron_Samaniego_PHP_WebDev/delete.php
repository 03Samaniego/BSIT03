<?php

require_once 'config.php';

$id = filter_var($_GET['id'] ?? null, FILTER_VALIDATE_INT);

if ($id) {
    try {
        $stmt = $conn->prepare("DELETE FROM users WHERE id = ?");
        $stmt->bind_param("i", $id);
        $stmt->execute();
        $stmt->close();
    } catch (mysqli_sql_exception $e) {
        // Return to the user list
    }
}

header("Location: read.php?message=deleted");
exit;