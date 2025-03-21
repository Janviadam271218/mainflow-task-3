<?php
// Database connection parameters
$servername = "localhost"; // Usually localhost
$username = "your_db_username"; // Your database username
$password = "your_db_password"; // Your database password
$dbname = "user_auth"; // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Check if form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // Validate password
    if ($password !== $confirm_password) {
        header("Location: index.html?error=Passwords do not match");
        exit();
    }

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Prepare and bind
    $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $username, $email, $hashed_password);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New record created successfully. You can now <a href='login.html'>login</a>.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close connections
    $stmt->close();
}

// Close the database connection
$conn->close();
?>
