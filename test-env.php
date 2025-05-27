<?php
$host = getenv('db_host');
$user = getenv('db_user');
$pass = getenv('db_pass');
$dbname = getenv('db_name');

$conn = @mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    http_response_code(500);
    echo "❌ DB connection failed: " . mysqli_connect_error();
} else {
    echo "✅ DB connected successfully!";
    mysqli_close($conn);
}
?>
