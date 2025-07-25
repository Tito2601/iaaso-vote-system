<?php
session_start();
require 'db.php';

// Check if user is logged in
if (!isset($_SESSION['student_id'])) {
    header('Location: login.php');
    exit();
}

// Fetch total votes
$total_votes = $conn->query("SELECT COUNT(*) as total FROM votes")->fetch_assoc()['total'];

// Fetch results for President
$presidents = $conn->query("SELECT c.name, COUNT(v.president_id) as votes 
                           FROM candidates c 
                           LEFT JOIN votes v ON c.id = v.president_id 
                           WHERE c.position='President' 
                           GROUP BY c.id");
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Results - IAASO VOTE SYSTEM</title>
    <link rel="stylesheet" href="assets/style.css">
</head>
<body>
    <?php include 'logo.php'; ?>
    <div class="card">
        <h2>Voting Results</h2>
        <div class="voter-info">
            <p class="voter-name"><?php echo htmlspecialchars($_SESSION['student_name']); ?></p>
            <?php 
            $student = $conn->query("SELECT id_number FROM students WHERE id = '{$_SESSION['student_id']}'")->fetch_assoc();
            ?>
            <p class="voter-id">ID: <?php echo htmlspecialchars($student['id_number']); ?></p>
        </div>
        <div class="results-container">
            <div class="total-votes">
                <span>Total Votes: <?php echo $total_votes; ?></span>
            </div>
            
            <div class="position-section">
                <h3>President</h3>
                <table>
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Votes</th>
                            <th>Percentage</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $presidents->fetch_assoc()): ?>
                        <tr>
                            <td><?php echo $row['name']; ?></td>
                            <td><?php echo $row['votes']; ?></td>
                            <td><?php echo $total_votes > 0 ? round(($row['votes'] / $total_votes) * 100, 2) : 0; ?>%</td>
                        </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="bottom-links">
            <a href="index.php" class="back-icon" title="Back to Home">←</a>
            <a href="logout.php" class="logout-button">Logout</a>
        </div>
    </div>
    <footer>
        &copy; <?php echo date('Y'); ?> IAASO VOTE SYSTEM
    </footer>
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

    .voter-info {
        text-align: center;
        margin-bottom: 20px;
        padding: 15px;
        background: #f4f8fc;
        border-radius: 6px;
        border: 1px solid #e3eaf7;
    }

    .voter-name {
        font-size: 1.2em;
        font-weight: bold;
        color: #1a237e;
        margin: 0 0 6px 0;
    }

    .voter-id {
        color: #1565c0;
        margin: 0;
        font-size: 0.95em;
    }

    .results-container {
        background: #fff;
        border: 1px solid #e3eaf7;
        border-radius: 6px;
        padding: 15px;
        margin-bottom: 15px;
    }

    .total-votes {
        text-align: center;
        font-size: 1em;
        color: #1a237e;
        padding: 12px;
        background: #f4f8fc;
        border-radius: 4px;
        margin-bottom: 15px;
        border: 1px solid #e3eaf7;
    }

    .position-section {
        margin-bottom: 25px;
    }

    .position-section:last-child {
        margin-bottom: 0;
    }

    .position-section h3 {
        color: #1565c0;
        margin-bottom: 12px;
        padding-bottom: 6px;
        border-bottom: 2px solid #e3eaf7;
        font-size: 1.1em;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-bottom: 15px;
        background: #fff;
        font-size: 0.9em;
    }

    thead {
        background: #1565c0;
        color: #fff;
    }

    th {
        padding: 8px 10px;
        text-align: left;
        font-weight: 600;
    }

    td {
        padding: 8px 10px;
        border-bottom: 1px solid #e3eaf7;
    }

    tr:last-child td {
        border-bottom: none;
    }

    tr:hover {
        background: #f4f8fc;
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
        transition: all 0.2s;
        font-size: 0.95em;
    }

    .logout-button:hover {
        background: #a93226;
        text-decoration: none;
        transform: translateY(-1px);
    }

    @media screen and (max-width: 600px) {
        .card {
            padding: 15px;
            margin: 70px auto 15px auto;
            width: 90%;
        }

        th, td {
            padding: 6px 8px;
            font-size: 0.85em;
        }
    }
    </style>
</body>
</html> 