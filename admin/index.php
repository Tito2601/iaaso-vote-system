<?php
session_start();
require '../db.php';
require '../activity_logger.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}

// Log admin login
$activityLogger = new ActivityLogger($conn);
$activityLogger->logActivity(
    $_SESSION['admin_id'], 
    'admin', 
    'login', 
    "Admin logged in"
);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .nav-links {
            display: flex;
            flex-direction: column;
            gap: 15px;
            margin: 20px auto;
            max-width: 300px;
            align-items: center;
        }
        .nav-links a {
            padding: 12px 20px;
            text-decoration: none;
            background-color: #f0f0f0;
            border-radius: 5px;
            color: #333;
            text-align: center;
            transition: all 0.3s ease;
            font-weight: 500;
            width: 100%;
        }
        .nav-links a:hover {
            background-color: #e0e0e0;
            transform: translateY(-2px);
            box-shadow: 0 2px 5px rgba(0,0,0,0.1);
        }
        .card {
            text-align: center;
        }
    </style>
</head>
<body>
    <?php include '../logo.php'; ?>
    <div class="card">
        <h2>Welcome, <?php echo htmlspecialchars($_SESSION['admin_username']); ?>!</h2>
        <nav class="nav-links">
            <a href="manage_candidates.php">Manage Candidates</a>
            <a href="view_results.php">View Results</a>
            <a href="profile.php">Profile</a>
            <a href="logout.php">Logout</a>
        </nav>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
</body>
</html> 