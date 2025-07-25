<?php
require 'db.php';
require 'activity_logger.php';
require 'csrf.php';
session_start();

// Initialize CSRF protection
$csrf = new CSRF();

if (!isset($_SESSION['student_id'])) {
    // Log unauthorized access attempt
    $activityLogger = new ActivityLogger($conn);
    $activityLogger->logActivity(
        null, 
        'system', 
        'unauthorized_access', 
        "Unauthorized access to voting page"
    );
    header('Location: login.php');
    exit();
}

$student_id = $_SESSION['student_id'];
$message = '';

// Log voting page access
$activityLogger = new ActivityLogger($conn);
$activityLogger->logActivity(
    $student_id, 
    'student', 
    'vote_page_access', 
    "Student accessed voting page"
);

// Verify student exists
$stmt = $conn->prepare("SELECT * FROM students WHERE id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$student_check = $stmt->get_result();
if ($student_check->num_rows === 0) {
    // Log invalid student attempt
    $activityLogger->logActivity(
        null, 
        'system', 
        'invalid_student', 
        "Invalid student ID attempted to vote: $student_id"
    );
    session_destroy();
    header('Location: login.php?error=invalid_student');
    exit();
}

// Check if already voted
$stmt = $conn->prepare("SELECT * FROM votes WHERE student_id = ?");
$stmt->bind_param("i", $student_id);
$stmt->execute();
$check = $stmt->get_result();
if ($check->num_rows > 0) {
    // Log repeated voting attempt
    $activityLogger->logActivity(
        $student_id, 
        'student', 
        'vote_already_cast', 
        "Student attempted to vote again"
    );
    $message = '<p class="success-message">You have already voted.</p>';
} else if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Validate CSRF token
    if (!isset($_POST['csrf_token']) || !CSRF::validateToken($_POST['csrf_token'])) {
        $activityLogger->logActivity(
            $student_id, 
            'system', 
            'csrf_attack', 
            "CSRF token validation failed"
        );
        $message = '<p class="error-message">Security error. Please try again.</p>';
        exit;
    }
    
    $president = (int)$_POST['president'];
    
    // Log voting attempt
    $activityLogger->logActivity(
        $student_id, 
        'student', 
        'vote_attempt', 
        "Student attempted to vote for President ID: $president"
    );
    
    // Verify candidate exists
    $stmt = $conn->prepare("SELECT * FROM candidates WHERE id = ? AND position = ?");
    $stmt->bind_param("is", $president, 'President');
    $stmt->execute();
    $president_check = $stmt->get_result();
    
    if ($president_check->num_rows === 0) {
        // Log invalid candidate selection
        $activityLogger->logActivity(
            $student_id, 
            'student', 
            'invalid_vote', 
            "Student selected invalid candidate ID: $president"
        );
        $message = '<p class="error-message">Invalid candidate selection.</p>';
    } else {
        // Insert vote using prepared statement
        $stmt = $conn->prepare("INSERT INTO votes (student_id, president_id) VALUES (?, ?)");
        $stmt->bind_param("ii", $student_id, $president);
        
        if ($stmt->execute()) {
            // Log successful vote
            $activityLogger->logActivity(
                $student_id, 
                'student', 
                'vote_cast', 
                "Student successfully cast vote for President ID: $president"
            );
            $message = '<p class="success-message">Your vote has been recorded!</p>';
        } else {
            // Log vote recording error
            $activityLogger->logActivity(
                $student_id, 
                'system', 
                'vote_error', 
                "Error recording vote for student ID: $student_id, candidate ID: $president"
            );
            $message = '<p class="error-message">Error recording your vote. Please try again.</p>';
        }
    }
}

// Fetch candidates
$presidents = $conn->query("SELECT * FROM candidates WHERE position='President'");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Vote - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'logo.php'; ?>
    <div class="card">
        <h2>IAASO VOTE SEASON 2025</h2>
        <div class="voter-info">
            <p class="voter-name"><?php echo htmlspecialchars($_SESSION['student_name']); ?></p>
            <p class="voter-id">ID: <?php echo htmlspecialchars($student_check->fetch_assoc()['id_number']); ?></p>
        </div>
        <?php if ($message): ?>
            <?php echo $message; ?>
        <?php endif; ?>
        <?php if ($check->num_rows === 0): ?>
        <form method="post">
            <?php echo CSRF::getTokenField(); ?>
            <label>PRESIDENT:
                <select name="president" required>
                    <option value="">Select President</option>
                    <?php while ($row = $presidents->fetch_assoc()): ?>
                        <option value="<?php echo $row['id']; ?>"><?php echo $row['name']; ?></option>
                    <?php endwhile; ?>
                </select>
            </label><br>
            <button type="submit">Submit Vote</button>
        </form>
        <?php endif; ?>
        <div class="bottom-links">
            <a href="index.php" class="back-icon" title="Back to Home">←</a>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
    <style>
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
    .bottom-links {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 20px;
        padding-top: 15px;
        border-top: 1px solid #e3eaf7;
    }
    .logout-button {
        display: inline-block;
        background: #c0392b;
        color: #fff;
        padding: 8px 20px;
        border-radius: 5px;
        text-decoration: none;
        font-weight: bold;
        transition: background 0.2s;
    }
    .logout-button:hover {
        background: #a93226;
        text-decoration: none;
    }
    </style>
</body>
</html> 