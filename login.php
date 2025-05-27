<?php
// Enable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Secure session
ini_set('session.cookie_httponly', 1);
ini_set('session.cookie_secure', 0); // Change to 1 only if you're using HTTPS locally
ini_set('session.use_strict_mode', 1);
session_start();

require_once 'config.php';

if (!$conn) {
    die("❌ Connection error in login.php: " . mysqli_connect_error());
} else {
    echo "✅ DB connected in login.php<br>";
}


// Security headers
header("Content-Security-Policy: default-src 'self'");
header("X-Content-Type-Options: nosniff");
header("X-Frame-Options: DENY");

// Handle form submission
if (isset($_POST['login'])) {
    $uname = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($uname) || empty($password)) {
        $message = "Username and password cannot be empty.";
    } else {
        echo "🔍 Checking user: " . htmlspecialchars($uname) . "<br>";

        $stmt = $conn->prepare("SELECT * FROM user_registration WHERE username = ?");
        $stmt->bind_param("s", $uname);
        $stmt->execute();
        $result = $stmt->get_result();
        $user = $result->fetch_assoc();

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['logged_in'] = true;
            $_SESSION['username'] = $uname;
            header("Location: index.php");
            exit();
        } else {
            $message = "Invalid username or password.";
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
<body>
    <h2>Login</h2>
    <?php if (!empty($message)) echo "<p style='color:red;'>$message</p>"; ?>
    <form method="POST" action="login.php">
        <label for="username">Username:</label><br/>
        <input type="text" id="username" name="username" required><br/><br/>
        <label for="password">Password:</label><br/>
        <input type="password" id="password" name="password" required><br/><br/>
        <input type="submit" name="login" value="Login">
    </form>
</body>
</html>
