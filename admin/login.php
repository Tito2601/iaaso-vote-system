<?php
require '../db.php';
require '../activity_logger.php';
session_start();
$message = '';

// Check if any admin exists
$check_admin = $conn->query("SELECT COUNT(*) as count FROM admins");
$admin_count = $check_admin->fetch_assoc()['count'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = $_POST['password'];
    
    // Log login attempt
    $activityLogger = new ActivityLogger($conn);
    $activityLogger->logActivity(
        null, 
        'system', 
        'login_attempt', 
        "Username: $username"
    );
    
    // Get admin record
    $result = $conn->query("SELECT * FROM admins WHERE username='$username'");
    if ($result->num_rows === 1) {
        $admin = $result->fetch_assoc();
        
        // Verify password using password_verify (assuming passwords were hashed during registration)
        if (password_verify($password, $admin['password'])) {
            // Update last login timestamp
            $conn->query("UPDATE admins SET last_login=NOW() WHERE id='$admin[id]'");
            
            // Log successful login
            $activityLogger->logActivity(
                $admin['id'], 
                'admin', 
                'login_success', 
                "Admin logged in successfully"
            );
            
            $_SESSION['admin_id'] = $admin['id'];
            $_SESSION['admin_username'] = $admin['username'];
            header('Location: index.php');
            exit();
        } else {
            // Log failed login attempt
            $activityLogger->logActivity(
                null, 
                'system', 
                'login_failure', 
                "Failed login attempt for username: $username"
            );
            $message = 'Invalid username or password.';
        }
    } else {
        // Log failed login attempt
        $activityLogger->logActivity(
            null, 
            'system', 
            'login_failure', 
            "Failed login attempt for non-existent username: $username"
        );
        $message = 'Invalid username or password.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Login - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
    .password-toggle {
        cursor: pointer;
        position: absolute;
        right: 30px;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1.2em;
        color: #888;
    }
    .form-group { position: relative; }
    .required-message { color: #c0392b; font-size: 0.95em; display: none; margin-bottom: 8px; }
    </style>
</head>
<body>
    <?php include '../logo.php'; ?>
    <div class="card">
        <h2>Admin Login</h2>
        <form method="post" id="adminLoginForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label>Username: <input type="text" name="username" id="username" required></label>
                <div class="required-message" id="usernameMsg">Username is required.</div>
            </div>
            <div class="form-group">
                <label>Password: <input type="password" name="password" id="password" required></label>
                <span class="password-toggle" onclick="togglePassword('password', this)">&#128065;</span>
                <div class="required-message" id="passwordMsg">Password is required.</div>
            </div>
            <button type="submit">Login</button>
        </form>
        <p><?php echo $message; ?></p>
        <?php if ($admin_count == 0): ?>
            <p>No admin account exists. <a href="register.php">Register as Admin</a></p>
        <?php endif; ?>
        <a href="../index.php">Back to Home</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
    <script>
    function togglePassword(id, el) {
        var input = document.getElementById(id);
        if (input.type === 'password') {
            input.type = 'text';
            el.style.color = '#1565c0';
        } else {
            input.type = 'password';
            el.style.color = '#888';
        }
    }
    document.getElementById('adminLoginForm').onsubmit = function(e) {
        var valid = true;
        var username = document.getElementById('username');
        var password = document.getElementById('password');
        if (!username.value.trim()) {
            document.getElementById('usernameMsg').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('usernameMsg').style.display = 'none';
        }
        if (!password.value.trim()) {
            document.getElementById('passwordMsg').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('passwordMsg').style.display = 'none';
        }
        if (!valid) e.preventDefault();
    };
    </script>
</body>
</html> 