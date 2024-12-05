<?php
session_start();

$reset_error = '';
$reset_success = '';

// Database connection
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "final_projectdb";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $token = trim($_POST['token']);
    $new_password = trim($_POST['new_password']);
    $confirm_password = trim($_POST['confirm_password']);

    if (empty($username) || empty($token) || empty($new_password) || empty($confirm_password)) {
        $reset_error = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $reset_error = 'Passwords do not match.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Update the password
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE username = ?");
            $stmt->bind_param("ss", $hashed_password, $username);
            if ($stmt->execute()) {
                $reset_success = 'Password successfully reset. You can now <a href="login.php">login</a>.';
            } else {
                $reset_error = 'Password reset failed. Please try again.';
            }
            $stmt->close();
        } else {
            $reset_error = 'Invalid username or token.';
        }
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: Arial, sans-serif;
            background: linear-gradient(135deg, #16A085, #F4D03F);
        }
        .container {
            width: 400px;
            background: #FFFFFF;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
            text-align: center;
        }
        .container h2 {
            margin-bottom: 20px;
            font-size: 24px;
            color: #007A33;
        }
        .container form {
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        .container input[type="text"], .container input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            color: #000;
        }
        .container button {
            width: 100%;
            padding: 10px;
            background-color: #FFD700;
            color: #007A33;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
        }
        .container button:hover {
            background-color: #FFC700;
        }
        .text-danger {
            color: red;
        }
        .text-success {
            color: green;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Reset Password</h2>
        <?php if ($reset_error != ''): ?>
            <p class="text-danger"><?= htmlspecialchars($reset_error) ?></p>
        <?php elseif ($reset_success != ''): ?>
            <p class="text-success"><?= htmlspecialchars($reset_success) ?></p>
        <?php endif; ?>
        <form action="reset_password.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="token" placeholder="Reset Token" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <button type="submit">Reset Password</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
