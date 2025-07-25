<?php
require 'db.php';
session_start();
$message = '';
if (isset($_GET['error']) && $_GET['error'] === 'invalid_student') {
    $message = 'Invalid student session. Please login again.';
}
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id_number = $conn->real_escape_string($_POST['id_number']);
    $password = $_POST['password'];
    $result = $conn->query("SELECT * FROM students WHERE id_number='$id_number'");
    if ($result->num_rows === 1) {
        $student = $result->fetch_assoc();
        if (password_verify($password, $student['password'])) {
            $_SESSION['student_id'] = $student['id'];
            $_SESSION['student_name'] = $student['name'];
            header('Location: vote.php');
            exit();
        } else {
            $message = '<p class="error-message">Invalid password.</p>';
        }
    } else {
        $message = '<p class="error-message">ID number not found.</p>';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="assets/style.css">
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
    <?php include 'logo.php'; ?>
    <div class="card">
        <h2>Student Login</h2>
        <form method="post" id="loginForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label>ID Number: <input type="text" name="id_number" id="id_number" required></label>
                <div class="required-message" id="idNumberMsg">ID Number is required.</div>
            </div>
            <div class="form-group">
                <label>Password: <input type="password" name="password" id="password" required></label>
                <button type="button" class="password-toggle" onclick="togglePassword('password', this)" title="Toggle password visibility">
                    <span class="show-password">👁️</span>
                    <span class="hide-password" style="display: none;">👁️‍🗨️</span>
                </button>
                <div class="required-message" id="passwordMsg">Password is required.</div>
            </div>
            <button type="submit">Login</button>
        </form>
        <p><?php echo $message; ?></p>
        <p class="regular-text">Don't have an account? <a href="register.php">Register here</a></p>
        <a href="index.php" class="back-icon" title="Back to Home">←</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
    <script>
    function togglePassword(id, el) {
        var input = document.getElementById(id);
        var showIcon = el.querySelector('.show-password');
        var hideIcon = el.querySelector('.hide-password');
        
        if (input.type === 'password') {
            input.type = 'text';
            showIcon.style.display = 'none';
            hideIcon.style.display = 'inline';
            el.style.color = '#1565c0';
        } else {
            input.type = 'password';
            showIcon.style.display = 'inline';
            hideIcon.style.display = 'none';
            el.style.color = '#888';
        }
    }
    document.getElementById('loginForm').onsubmit = function(e) {
        var valid = true;
        var idNumber = document.getElementById('id_number');
        var password = document.getElementById('password');
        if (!idNumber.value.trim()) {
            document.getElementById('idNumberMsg').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('idNumberMsg').style.display = 'none';
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