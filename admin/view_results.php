<?php
session_start();
require '../db.php';
if (!isset($_SESSION['admin_id'])) {
    header('Location: login.php');
    exit();
}
// Fetch total votes
$total_votes = $conn->query("SELECT COUNT(*) as total FROM votes")->fetch_assoc()['total'];
// Fetch results for President
$presidents = $conn->query("SELECT c.name, COUNT(v.president_id) as votes FROM candidates c LEFT JOIN votes v ON c.id = v.president_id WHERE c.position='President' GROUP BY c.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>View Results - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="../assets/style.css">
</head>
<body>
    <?php include '../logo.php'; ?>
    <div class="card">
        <h2>Detailed Voting Results</h2>
        <p>Total Votes: <?php echo $total_votes; ?></p>
        <h3>President</h3>
        <table border="1">
            <tr><th>Name</th><th>Votes</th><th>Percentage</th></tr>
            <?php while ($row = $presidents->fetch_assoc()): ?>
            <tr>
                <td><?php echo $row['name']; ?></td>
                <td><?php echo $row['votes']; ?></td>
                <td><?php echo $total_votes > 0 ? round(($row['votes'] / $total_votes) * 100, 2) : 0; ?>%</td>
            </tr>
            <?php endwhile; ?>
        </table>
        <a href="index.php">Back to Dashboard</a>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
</body>
</html>