<?php

mysqli_report(MYSQLI_REPORT_OFF);

$conn = new mysqli('localhost', 'root', '', 'app_db');

if ($conn->connect_error) {
    die("Database connection failed: " . $conn->connect_error);
}

?>