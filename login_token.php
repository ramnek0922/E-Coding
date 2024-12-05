<?php
session_start();

$login_error = '';

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
        $login_error = 'All fields are required.';
    } elseif ($new_password !== $confirm_password) {
        $login_error = 'Passwords do not match.';
    } elseif (strlen($new_password) < 8) {
        $login_error = 'Password must be at least 8 characters long.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND reset_token = ? AND reset_token_expiry > NOW()");
        $stmt->bind_param("ss", $username, $token);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // User found and token is valid
            $hashed_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ?, reset_token = NULL, reset_token_expiry = NULL WHERE username = ?");
            $stmt->bind_param("ss", $hashed_password, $username);
            if ($stmt->execute()) {
                // Set success message in session and redirect to login page
                $_SESSION['password_reset_success'] = 'Password updated successfully';
                header('Location: login.php');
                exit;
            } else {
                $login_error = 'Failed to update the password.';
            }
        } else {
            $login_error = 'Invalid username or token.';
        }
        $stmt->close();
    }
}
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Token</title>
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
            border-radius: 7px;
            cursor: pointer;
            font-size: 16px;
        }
        .container button:hover {
            background-color: #FFC700;
        }
        .text-danger {
            color: red;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Login with Token</h2>
        <?php if ($login_error != ''): ?>
            <p class="text-danger"><?= htmlspecialchars($login_error) ?></p>
        <?php endif; ?>
        <form action="login_token.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="text" name="token" placeholder="Token" required>
            <input type="password" name="new_password" placeholder="New Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm New Password" required>
            <button type="submit">Login and Reset Password</button>
        </form>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
