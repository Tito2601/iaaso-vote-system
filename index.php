<?php
session_start();
require 'db.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="assets/style.css">
    <style>
        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 10px;
            margin: 20px 0;
        }
        .nav-links a {
            padding: 10px 20px;
            text-decoration: none;
            background-color: #f0f0f0;
            border-radius: 5px;
            color: #333;
            text-align: center;
            transition: background-color 0.3s;
        }
        .nav-links a:hover {
            background-color: #e0e0e0;
        }
        .voter-info {
            text-align: center;
            margin-bottom: 20px;
            padding: 15px;
            background: #f4f8fc;
            border-radius: 5px;
            border: 1px solid #e3eaf7;
        }
        .voter-name {
            font-size: 1.2em;
            font-weight: bold;
            color: #1a237e;
            margin: 0 0 5px 0;
        }
        .voter-id {
            color: #1565c0;
            margin: 0;
            font-size: 0.9em;
        }
    </style>
</head>
<body>
    <?php include 'logo.php'; ?>
    <div class="card">
        <h1>Welcome to IAASO VOTE SYSTEM</h1>
        <?php if (isset($_SESSION['student_id'])): ?>
            <div class="voter-info">
                <p class="voter-name"><?php echo htmlspecialchars($_SESSION['student_name']); ?></p>
                <?php 
                $student = $conn->query("SELECT id_number FROM students WHERE id = '{$_SESSION['student_id']}'")->fetch_assoc();
                ?>
                <p class="voter-id">ID: <?php echo htmlspecialchars($student['id_number']); ?></p>
            </div>
            <div class="nav-links">
                <a href="vote.php">Cast Your Vote</a>
                <a href="results.php">View Results</a>
                <a href="logout.php">Logout</a>
            </div>
        <?php else: ?>
            <p>Please login or register to participate in the voting.</p>
            <div class="nav-links">
                <a href="login.php">Login</a>
                <a href="register.php">Register</a>
            </div>
        <?php endif; ?>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
</body>
</html> 