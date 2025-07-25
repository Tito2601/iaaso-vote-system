<?php
require 'db.php';
require 'logger.php';
require 'activity_logger.php';
session_start();
$message = '';

function validateInput($input, $type) {
    if (empty($input)) {
        return "Field is required";
    }
    
    switch($type) {
        case 'name':
            if (!preg_match("/^[a-zA-Z\s]+$/", $input)) {
                return "Name must contain only letters and spaces";
            }
            break;
            
        case 'id_number':
            if (empty(trim($input))) {
                return "ID number cannot be empty";
            }
            break;
            
        case 'password':
            if (strlen($input) < 8) {
                return "Password must be at least 8 characters long";
            }
            break;
    }
    return true;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = $_POST['name'] ?? '';
        $id_number = $_POST['id_number'] ?? '';
        $password = $_POST['password'] ?? '';
        
        // Validate inputs
        $errors = [];
        
        if (($validation = validateInput($name, 'name')) !== true) {
            $errors[] = $validation;
        }
        
        if (($validation = validateInput($id_number, 'id_number')) !== true) {
            $errors[] = $validation;
        }
        
        if (($validation = validateInput($password, 'password')) !== true) {
            $errors[] = $validation;
        }
        
        if (!empty($errors)) {
            $message = '<div class="error-message">' . implode('<br>', $errors) . '</div>';
            $activityLogger = new ActivityLogger($conn);
            $activityLogger->logActivity(null, 'system', 'registration_attempt', json_encode($errors));
            throw new Exception("Validation failed");
        }
        
        // Sanitize inputs
        $name = $conn->real_escape_string($name);
        $id_number = $conn->real_escape_string($id_number);
        
        // Check if ID number already exists
        $check = $conn->query("SELECT * FROM students WHERE id_number='$id_number'");
        if ($check->num_rows > 0) {
            $message = '<p class="error-message">ID number already registered.</p>';
            $activityLogger = new ActivityLogger($conn);
            $activityLogger->logActivity(null, 'system', 'registration_duplicate', "ID: $id_number");
            throw new Exception("ID already exists");
        }
        
        // Hash password
        $password = password_hash($password, PASSWORD_DEFAULT);
        
        // Insert into database
        $sql = "INSERT INTO students (name, id_number, password, created_at) 
                VALUES ('$name', '$id_number', '$password', NOW())";
        
        if ($conn->query($sql)) {
            $studentId = $conn->insert_id;
            $activityLogger = new ActivityLogger($conn);
            $activityLogger->logActivity($studentId, 'student', 'registration_success', 
                "Name: $name, ID: $id_number");
            $message = '<p class="success-message">Registration successful!</p>';
        } else {
            $message = '<p class="error-message">Registration failed. Please try again.</p>';
            $activityLogger = new ActivityLogger($conn);
            $activityLogger->logActivity(null, 'system', 'registration_error', $conn->error);
            throw new Exception("Database error");
        }
        
    } catch (Exception $e) {
        $activityLogger = new ActivityLogger($conn);
        $activityLogger->logActivity(null, 'system', 'registration_exception', $e->getMessage());
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Register - IAASO VOTE SYSTEM</title>
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
    .register-button {
        background: #27ae60 !important;  /* Green color */
    }
    .register-button:hover {
        background: #219a52 !important;  /* Darker green on hover */
    }
    .login-button {
        display: inline-block;
        background: #1565c0;
        color: #fff;
        padding: 10px 22px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        margin-top: 15px;
        transition: background 0.2s;
    }
    .login-button:hover {
        background: #0d47a1;
        text-decoration: none;
    }
    </style>
</head>
<body>
    <?php include 'logo.php'; ?>
    <div class="card">
        <h2>Student Registration</h2>
        <form method="post" id="registerForm" autocomplete="off" novalidate>
            <div class="form-group">
                <label>Full Name: <input type="text" name="name" id="name" required></label>
                <div class="required-message" id="nameMsg">Full Name is required.</div>
            </div>
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
            <button type="submit" class="register-button">Register</button>
        </form>
        <p><?php echo $message; ?></p>
        <?php if (strpos($message, 'successful') !== false): ?>
            <a href="login.php" class="login-button">Go to Login</a>
        <?php endif; ?>
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
    document.getElementById('registerForm').onsubmit = function(e) {
        var valid = true;
        var name = document.getElementById('name');
        var idNumber = document.getElementById('id_number');
        var password = document.getElementById('password');
        if (!name.value.trim()) {
            document.getElementById('nameMsg').style.display = 'block';
            valid = false;
        } else {
            document.getElementById('nameMsg').style.display = 'none';
        }
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