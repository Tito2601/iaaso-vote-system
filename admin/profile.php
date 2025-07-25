<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $conn->real_escape_string($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $admin_id = $_SESSION['admin_id'];
    $check = $conn->query("SELECT * FROM admins WHERE username='$username' AND id != '$admin_id'");
    if ($check->num_rows > 0) {
        $message = 'Username already exists.';
    } else {
        $conn->query("UPDATE admins SET username='$username', password='$password' WHERE id='$admin_id'");
        $_SESSION['admin_username'] = $username;
        $message = 'Profile updated successfully.';
    }
}
$admin = $conn->query("SELECT * FROM admins WHERE id='{$_SESSION['admin_id']}'")->fetch_assoc();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Profile - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include '../logo.php'; ?>
    <div class="card">
        <h2>Admin Profile</h2>
        <form method="post">
            <label>Username: <input type="text" name="username" value="<?php echo $admin['username']; ?>" required></label><br>
            <label>New Password: <input type="password" name="password" required></label><br>
            <button type="submit">Update Profile</button>
        </form>
        <p><?php echo $message; ?></p>
        <a href="index.php">Back to Dashboard</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
</body>
</html> 