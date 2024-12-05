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

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['get_token'])) {
    $username = trim($_POST['username']);
    $recovery_email = trim($_POST['recovery_email']);

    if (empty($username) || empty($recovery_email)) {
        $reset_error = 'Both fields are required.';
    } else {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? AND recovery_email = ?");
        $stmt->bind_param("ss", $username, $recovery_email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows == 1) {
            // Generate a password reset token
            $token = bin2hex(random_bytes(16)); // Generate a random token
            $stmt = $conn->prepare("UPDATE users SET reset_token = ?, reset_token_expiry = DATE_ADD(NOW(), INTERVAL 1 HOUR) WHERE username = ?");
            $stmt->bind_param("ss", $token, $username);
            $stmt->execute();

            // Debug: Check if the update was successful
            if ($stmt->affected_rows > 0) {
                // Store token and username in session
                $_SESSION['reset_token'] = $token;
                $_SESSION['reset_username'] = $username;

                // Display success message with token
                $reset_success = 'Password reset token: ' . $token;
            } else {
                $reset_error = 'Failed to set reset token.';
            }
        } else {
            $reset_error = 'No account found with that username and recovery email combination.';
        }
    }
} elseif ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['proceed'])) {
    // Redirect to login_token.php
    header('Location: login_token.php');
    exit;
}

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .container input[type="text"], .container input[type="email"] {
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
            margin-bottom: 10px;
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
        <h2>Forgot Password</h2>
        <?php if ($reset_error != ''): ?>
            <p class="text-danger"><?= htmlspecialchars($reset_error) ?></p>
        <?php elseif ($reset_success != ''): ?>
            <p class="text-success"><?= htmlspecialchars($reset_success) ?></p>
            <form action="forgot_password.php" method="post">
                <button type="submit" name="proceed">Proceed to Reset Password</button>
            </form>
        <?php else: ?>
            <form action="forgot_password.php" method="post">
                <input type="text" name="username" placeholder="Username" required>
                <input type="email" name="recovery_email" placeholder="Recovery Email" required>
                <button type="submit" name="get_token">Get Reset Token</button>
            </form>
        <?php endif; ?>
        <p><a href="login.php">Back to Login</a></p>
    </div>
</body>
</html>
