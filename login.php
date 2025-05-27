<?php
// Enable error reporting
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Secure session
ini_set('session.cookie_httponly', 1);
ini_set('session.use_strict_mode', 1);
session_start();

// Security headers
header("Content-Security-Policy: default-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

echo "<pre>";

// DB connection with timeout
ini_set('mysqli.connect_timeout', 5);
$host = getenv('db_host') ?: 'localhost';
$user = getenv('db_user') ?: 'root';
$pass = getenv('db_pass') ?: '';
$dbname = getenv('db_name') ?: 'car_rental_database';

echo "Connecting to DB...\n";
$conn = @mysqli_connect($host, $user, $pass, $dbname);

if (!$conn) {
    die("❌ DB connection failed: " . mysqli_connect_error());
}
echo "✅ Connected to DB\n";

$message = '';

// Handle login
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['login'])) {
    $uname = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($uname) || empty($password)) {
        $message = "❗ Username and password required.";
    } else {
        echo "🔍 Checking user: $uname\n";
        $stmt = $conn->prepare("SELECT * FROM user_registration WHERE username = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $uname;
            echo "✅ Login successful. Redirecting...\n";
            header("Location: index.php");
            exit();
        } else {
            $message = "❌ Invalid username or password.";
        }
    }
}
echo "</pre>";
?>

<!DOCTYPE html>
<html>
<head><title>Login</title></head>
<body>
    <h2>Login</h2>
    <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST" action="login.php">
        <label>Username:</label><br>
        <input type="text" name="username" required><br><br>
        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
