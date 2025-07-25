<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
$message = '';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['add_candidate'])) {
        $name = $conn->real_escape_string($_POST['name']);
        $conn->query("INSERT INTO candidates (name, position) VALUES ('$name', 'President')");
        $message = 'President candidate added successfully.';
        
        // Log the activity
        require '../activity_logger.php';
        $activityLogger = new ActivityLogger($conn);
        $activityLogger->logActivity(
            $_SESSION['admin_id'], 
            'admin', 
            'add_president_candidate', 
            "Added candidate: $name"
        );
    } elseif (isset($_POST['delete_candidate'])) {
        $id = (int)$_POST['candidate_id'];
        $conn->query("DELETE FROM candidates WHERE id='$id'");
        $message = 'President candidate deleted successfully.';
        
        // Log the activity
        $candidate = $conn->query("SELECT name FROM candidates WHERE id='$id'")->fetch_assoc();
        $activityLogger = new ActivityLogger($conn);
        $activityLogger->logActivity(
            $_SESSION['admin_id'], 
            'admin', 
            'delete_president_candidate', 
            "Deleted candidate: " . $candidate['name']
        );
    }
}
$candidates = $conn->query("SELECT * FROM candidates WHERE position='President' ORDER BY name");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Candidates - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="../assets/style.css">
    <style>
        .candidates-table {
            width: 100%;
            border-collapse: collapse;
            margin: 20px 0;
        }
        .candidates-table th, .candidates-table td {
            padding: 12px;
            text-align: left;
            border: 1px solid #e3eaf7;
        }
        .candidates-table th {
            background-color: #f4f8fc;
            font-weight: bold;
            color: #1a237e;
        }
        .candidates-table tr:nth-child(even) {
            background-color: #f8fafd;
        }
        .no-candidates {
            text-align: center;
            padding: 20px;
            background-color: #f4f8fc;
            border: 1px solid #e3eaf7;
            border-radius: 6px;
            margin: 20px 0;
            color: #666;
        }
        .add-candidate-form {
            background: #f4f8fc;
            padding: 20px;
            border-radius: 6px;
            border: 1px solid #e3eaf7;
            margin-bottom: 20px;
        }
        .add-candidate-form label {
            display: block;
            margin-bottom: 10px;
            color: #1a237e;
            font-weight: bold;
        }
        .add-candidate-form input, .add-candidate-form select {
            width: 100%;
            padding: 8px;
            margin-bottom: 15px;
            border: 1px solid #e3eaf7;
            border-radius: 4px;
        }
        .add-candidate-form button {
            background: #27ae60;
            color: white;
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .add-candidate-form button:hover {
            background: #219a52;
        }
        .delete-button {
            background: #c0392b;
            color: white;
            padding: 6px 12px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        .delete-button:hover {
            background: #a93226;
        }
    </style>
</head>
<body>
    <?php include '../logo.php'; ?>
    <div class="card">
        <h2>Manage Candidates</h2>
        <?php if ($message): ?>
            <p class="success-message"><?php echo $message; ?></p>
        <?php endif; ?>
        
        <div class="add-candidate-form">
            <h2>Add New President Candidate</h2>
            <form method="post">
                <label>Name:</label>
                <input type="text" name="name" required>
                <button type="submit" name="add_candidate">Add President Candidate</button>
            </form>
        </div>

        <h3>Current Candidates</h3>
        <?php if ($candidates->num_rows === 0): ?>
            <div class="no-candidates">
                <p>No candidates have been added yet. Use the form above to add candidates.</p>
            </div>
        <?php else: ?>
            <table class="candidates-table">
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
                <?php while ($row = $candidates->fetch_assoc()): ?>
                <tr>
                    <td><?php echo htmlspecialchars($row['name']); ?></td>
                    <td>
                        <form method="post" style="display: inline;">
                            <input type="hidden" name="candidate_id" value="<?php echo $row['id']; ?>">
                            <button type="submit" name="delete_candidate" class="delete-button" onclick="return confirm('Are you sure you want to delete this president candidate?')">Delete</button>
                        </form>
                    </td>
                </tr>
                <?php endwhile; ?>
            </table>
        <?php endif; ?>
        
        <div class="bottom-links">
            <a href="index.php" class="back-button">Back to Dashboard</a>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
</body>
</html> 