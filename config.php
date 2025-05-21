<?php
$host = getenv('DB_host');
$user = getenv('DB_user');
$password = getenv('DB_pass');
$dbname = getenv('DB_name');

$conn = mysqli_connect($host, $user, $password, $dbname);

if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
?>
