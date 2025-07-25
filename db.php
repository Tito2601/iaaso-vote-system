<?php
$host = 'localhost';
$db   = 'iaa_vote_system';
$user = 'root';
$pass = '';

try {
    $conn = new mysqli($host, $user, $pass, $db);

    if ($conn->connect_error) {
        throw new Exception('Connection failed: ' . $conn->connect_error);
    }

    // Set charset to ensure proper encoding
    $conn->set_charset("utf8mb4");
} catch (Exception $e) {
    die('Database connection error: ' . $e->getMessage());
}

// Register shutdown function to close the connection
register_shutdown_function(function() use ($conn) {
    if ($conn instanceof mysqli) {
        $conn->close();
    }
});
?> 