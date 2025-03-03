<?php
// Database connection settings
$servername = "localhost";
$username = "root";  // Change if your username is different
$password = "";  // Database password (default is empty for XAMPP)
$dbname = "admin_login";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input_username = $_POST['username'];
    $input_password = $_POST['password'];

    // Query to check if username exists
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $input_username);  // "s" is for string
    $stmt->execute();
    $result = $stmt->get_result();
    
    // If user exists, verify password
    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();
        if (password_verify($input_password, $user['password'])) {
            // Login successful
            session_start();
            $_SESSION['admin_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            header("Location: dashboard.php");  // Redirect to admin dashboard
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No user found with that username.";
    }

    $stmt->close();
}

$conn->close();
?>
