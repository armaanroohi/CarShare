<?php
// Enable error reporting for development only (disable in production)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Optional: toggle this to false in production
$debug = true;

// Retrieve environment variables or fallback to local dev defaults
$host = getenv('db_host') ?: 'localhost';
$user = getenv('db_user') ?: 'root';
$password = getenv('db_pass') ?: '';
$dbname = getenv('db_name') ?: 'car_rental_database';

// Optional debug output
if ($debug) {
    echo "<pre>";
    echo "Host: $host\n";
    echo "User: $user\n";
    echo "DB Name: $dbname\n";
    echo "</pre>";
}

// Set MySQLi timeout (for production hangs)
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

// Attempt to connect to the database
$conn = @mysqli_connect($host, $user, $password, $dbname);

// Check connection
if (!$conn) {
    die("❌ Database connection failed: " . mysqli_connect_error());
} else if ($debug) {
    echo "✅ Connected to the database successfully!";
}
?>
