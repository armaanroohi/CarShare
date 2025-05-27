<?php
session_start();
require_once 'config.php';

if (isset($_POST['submit'])) {
    $first_name = trim($_POST['first_name']);
    $middle_name = trim($_POST['middle_name']);
    $last_name = trim($_POST['last_name']);
    $username = trim($_POST['username']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    $is_admin = 0;

    // Check if passwords match
    if ($password !== $confirm_password) {
        echo "<script>alert('Passwords do not match.');</script>";
    } else {
        // Check if username already exists
        $stmt = $conn->prepare("SELECT username FROM user_registration WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            echo "<script>alert('Username already exists.');</script>";
        } else {
            // Hash the password
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);

            // Insert new user
            $stmt = $conn->prepare("INSERT INTO user_registration (first_name, middle_name, last_name, username, password, is_admin) VALUES (?, ?, ?, ?, ?, ?)");
            $stmt->bind_param("sssssi", $first_name, $middle_name, $last_name, $username, $hashed_password, $is_admin);

            if ($stmt->execute()) {
                echo "<script>alert('Account created successfully.'); window.location.href='login.php';</script>";
            } else {
                echo "<script>alert('Registration failed. Please try again.');</script>";
            }
        }
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register New Account</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f2f2f2;
            padding: 50px;
        }
        .form-container {
            background: #fff;
            padding: 30px;
            margin: auto;
            width: 400px;
            box-shadow: 0px 0px 10px #ccc;
            border-radius: 8px;
        }
        .form-container h2 {
            margin-bottom: 25px;
            text-align: center;
            color: #333;
        }
        input[type="text"], input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 8px 0 20px;
            border: 1px solid #ccc;
            border-radius: 4px;
        }
        input[type="submit"] {
            background: #007BFF;
            color: white;
            border: none;
            padding: 12px;
            width: 100%;
            cursor: pointer;
            border-radius: 4px;
        }
        input[type="submit"]:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <div class="form-container">
        <h2>Create Your Account</h2>
        <form action="" method="POST">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" required>

            <label for="middle_name">Middle Name:</label>
            <input type="text" name="middle_name">

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" required>

            <label for="username">Username:</label>
            <input type="text" name="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" required>

            <label for="confirm_password">Confirm Password:</label>
            <input type="password" name="confirm_password" required>

            <input type="submit" name="submit" value="Register">
        </form>
    </div>
</body>
</html>
