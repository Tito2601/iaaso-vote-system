<?php
require '../db.php';
session_start();
$message = '';

// Check if any admin exists
$check_admin = $conn->query("SELECT COUNT(*) as count FROM admins");
$admin_count = $check_admin->fetch_assoc()['count'];

if ($admin_count > 0) {
    $message = 'Admin registration is closed. Only one admin account is allowed.';
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    if (empty($username) || empty($password)) {
        $message = 'Please fill in all fields.';
    } else {
        // Hash the password
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into database
        $sql = "INSERT INTO admins (username, password, created_at) VALUES ('$username', '$hashed_password', NOW())";
        if ($conn->query($sql)) {
            // Log the registration
            require '../activity_logger.php';
            $activityLogger = new ActivityLogger($conn);
            $activityLogger->logActivity(
                null, 
                'system', 
                'admin_registration', 
                "New admin registered: $username"
            );
            
            $message = 'Registration successful! <a href="login.php">Click here to login</a>';
        } else {
            $message = 'Error during registration. Please try again.';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Registration - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
    .card {
        background: #fff;
        border-radius: 8px;
        box-shadow: 0 2px 16px rgba(0, 0, 0, 0.1);
        border: 1px solid #e3eaf7;
        padding: 25px;
        margin: 70px auto 20px auto;
        max-width: 500px;
        width: 85%;
    }

    .admin-info {
        text-align: center;
        margin-bottom: 20px;
        padding: 15px;
        background: #f4f8fc;
        border-radius: 6px;
        border: 1px solid #e3eaf7;
    }

    .admin-name {
        font-size: 1.2em;
        font-weight: bold;
        color: #1a237e;
        margin: 0 0 6px 0;
    }

    .admin-role {
        color: #1565c0;
        margin: 0;
        font-size: 0.95em;
    }

    .register-form {
        background: #f4f8fc;
        border-radius: 6px;
        padding: 15px;
        border: 1px solid #e3eaf7;
    }

    .form-group {
        margin-bottom: 15px;
    }

    .form-group:last-child {
        margin-bottom: 0;
    }

    .form-group label {
        display: block;
        margin-bottom: 5px;
        color: #1a237e;
        font-weight: bold;
        font-size: 0.95em;
    }

    .form-group input {
        width: 100%;
        padding: 8px 12px;
        border: 1px solid #e3eaf7;
        border-radius: 4px;
        font-size: 0.95em;
    }

    .form-group input:focus {
        outline: none;
        border-color: #1565c0;
        box-shadow: 0 0 0 2px rgba(21, 101, 192, 0.1);
    }

    .submit-button {
        background: #27ae60;
        color: #fff;
        padding: 10px 20px;
        border: none;
        border-radius: 5px;
        cursor: pointer;
        font-weight: bold;
        font-size: 0.95em;
        transition: all 0.2s;
    }

    .submit-button:hover {
        background: #219a52;
        transform: translateY(-1px);
    }

    .bottom-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #e3eaf7;
    }

    .back-button {
        display: inline-block;
        background: #1565c0;
        color: #fff;
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.2s;
        font-size: 0.95em;
    }

    .back-button:hover {
        background: #0d47a1;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .logout-button {
        display: inline-block;
        background: #c0392b;
        color: #fff;
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: all 0.2s;
        font-size: 0.95em;
    }

    .logout-button:hover {
        background: #a93226;
        text-decoration: none;
        transform: translateY(-1px);
    }

    .success-message {
        color: #27ae60;  /* Green color for success messages */
        font-weight: bold;
        margin-bottom: 15px;
        padding: 10px;
        background: #e8f5e9;  /* Light green background */
        border-radius: 4px;
        border: 1px solid #27ae60;
    }

    @media screen and (max-width: 600px) {
        .card {
            padding: 15px;
            margin: 70px auto 15px auto;
            width: 90%;
        }
    }
    </style>
</head>
<body>
    <div class="card">
        <h2>Admin Registration</h2>
        <?php if ($admin_count == 0): ?>
            <form method="post">
                <label>Username: <input type="text" name="username" required></label><br>
                <label>Password: <input type="password" name="password" required></label><br>
                <button type="submit">Register</button>
            </form>
        <?php endif; ?>
        <?php if (strpos($message, 'Registration successful') !== false): ?>
            <div class="success-message"><?php echo $message; ?></div>
        <?php else: ?>
            <p><?php echo $message; ?></p>
        <?php endif; ?>
        <a href="login.php">Back to Login</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAA Institute Vote System
    </footer>
</body>
</html> 