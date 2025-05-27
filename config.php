<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Retrieve environment variables or use default values
$host = getenv('db_host') ?: 'localhost';
$user = getenv('db_user') ?: 'root';
$password = getenv('db_pass') ?: '';
$dbname = getenv('db_name') ?: 'car_rental_database';

// Debug output
echo "<pre>";
echo "Host: $host\n";
echo "User: $user\n";
echo "DB Name: $dbname\n";
echo "</pre>";

// Attempt database connection
$conn = mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
} else {
    echo "✅ Connected to the database successfully!";
}
?>
