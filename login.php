<?php
session_start();
$conn = mysqli_connect("localhost", "root", "", "user_auth");

if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}

$username_email = $_POST['username_email'];
$password = $_POST['password'];

// Fetch user from DB
$sql = "SELECT * FROM users WHERE username='$username_email' OR email='$username_email'";
$result = mysqli_query($conn, $sql);
$user = mysqli_fetch_assoc($result);

if ($user && password_verify($password, $user['password'])) {
    $_SESSION['user_id'] = $user['id'];
    header("Location: dashboard.php");
} else {
    header("Location: login.html?error=Invalid credentials");
}

mysqli_close($conn);
?>