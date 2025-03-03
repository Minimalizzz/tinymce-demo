<?php
session_start();

// Check if admin is logged in
if (!isset($_SESSION['admin_id'])) {
    header("Location: login.html");  // Redirect to login page if not logged in
    exit();
}

echo "<h1>Welcome, " . $_SESSION['username'] . "!</h1>";
echo "<p>You are logged in as an admin.</p>";
echo "<a href='logout.php'>Logout</a>";
?>
