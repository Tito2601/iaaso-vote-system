<?php
require 'db.php';

// Delete all records from admins table
$conn->query("DELETE FROM admins");

echo "All admin accounts have been removed. You can now register a new admin account.";
?> 