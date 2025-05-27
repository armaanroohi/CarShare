<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Get environment variables
$host = getenv('db_host');
$user = getenv('db_user');
$password = getenv('db_pass');
$dbname = getenv('db_name');

// Debug output
echo "<pre>";
echo "Host: $host\n";
echo "User: $user\n";
echo "DB Name: $dbname\n";
echo "</pre>";

// Try to connect
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
} else {
    echo "✅ Connected to the database successfully!";
}
?>
