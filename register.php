<?php
session_start();

$register_error = '';
$register_success = '';

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
    // Trim and sanitize input
    $username = trim($_POST['username']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $email = trim($_POST['email']);
    $name = trim($_POST['name']);
    $address = trim($_POST['address']);
    $phone = trim($_POST['phone']);
    $recovery_email = trim($_POST['recovery_email']);

    // Validate input
    if (empty($username) || empty($password) || empty($confirm_password) || empty($email) || empty($name) || empty($address) || empty($phone) || empty($recovery_email)) {
        $register_error = 'All fields are required.';
    } elseif (!preg_match('/^[a-zA-Z0-9]*$/', $username)) {
        $register_error = 'Username can only contain letters and numbers.';
    } elseif ($password !== $confirm_password) {
        $register_error = 'Passwords do not match.';
    } elseif (strlen($password) < 8) {
        $register_error = 'Password must be at least 8 characters long.';
    } elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $register_error = 'Invalid email format.';
    } elseif (!filter_var($recovery_email, FILTER_VALIDATE_EMAIL)) {
        $register_error = 'Invalid recovery email format.';
    } elseif (!isset($_POST['terms'])) {
        $register_error = 'You must agree to the terms.';
    } else {
        // Check if username or email already exists
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = ? OR email = ?");
        $stmt->bind_param("ss", $username, $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $register_error = 'Username or email already exists.';
        } else {
            // Insert user into database
            $stmt = $conn->prepare("INSERT INTO users (username, email, password, full_name, address, phone_number, recovery_email, created_at) VALUES (?, ?, ?, ?, ?, ?, ?, NOW())");
            $hashed_password = password_hash($password, PASSWORD_DEFAULT);
            $stmt->bind_param("sssssss", $username, $email, $hashed_password, $name, $address, $phone, $recovery_email);
            if ($stmt->execute()) {
                $_SESSION['loggedin'] = true;
                $_SESSION['username'] = $username;
                session_regenerate_id(true); // Regenerate session ID on login

                // Set the success message
                $register_success = 'Registration successful! You can now log in.';
                header('Location: register.php?success=true');
                exit;
            } else {
                $register_error = 'Registration failed. Please try again.';
            }
            $stmt->close();
        }
    }
}

// Display success message if redirected from a successful registration
if (isset($_GET['success']) && $_GET['success'] == 'true') {
    $register_success = 'Registration successful! You can now log in.';
}

$conn->close();

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration</title>
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
        .container input[type="text"], .container input[type="password"], .container input[type="email"] {
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
        .container .additional-links {
            margin-top: 10px;
        }
        .container .additional-links a {
            color: #007A33;
            text-decoration: none;
        }
        .container .additional-links a:hover {
            text-decoration: underline;
        }
        .remember-me {
            display: flex;
            align-items: center;
            margin-bottom: 15px;
            width: 100%;
            justify-content: left;
            color: #000;
        }
        .remember-me input {
            margin-right: 5px;
        }
        .remember-me a {
            color: #007A33;
            text-decoration: none;
        }
        .remember-me a:hover {
            text-decoration: underline;
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
        <h2>User Registration</h2>
        <?php if ($register_error != ''): ?>
            <p class="text-danger"><?= htmlspecialchars($register_error) ?></p>
        <?php elseif ($register_success != ''): ?>
            <p class="text-success"><?= htmlspecialchars($register_success) ?></p>
        <?php endif; ?>
        <form action="register.php" method="post">
            <input type="text" name="username" placeholder="Username" required>
            <input type="email" name="email" placeholder="Email Address" required>
            <input type="text" name="name" placeholder="Full Name" required>
            <input type="text" name="address" placeholder="Address" required>
            <input type="text" name="phone" placeholder="Phone Number" required>
            <input type="email" name="recovery_email" placeholder="Recovery Email Address" required>
            <input type="password" name="password" placeholder="Password" required>
            <input type="password" name="confirm_password" placeholder="Confirm Password" required>
            <div class="remember-me">
                <input type="checkbox" name="terms" required>
                <label>I agree to the <a href="termsandconditions.php" target="_blank">terms and conditions</a></label>
            </div>
            <button type="submit">Register</button>
        </form>
        <div class="additional-links">
            <p>Already have an account? <a href="login.php">Login here</a></p>
            <p><a href="forgot_password.php">Forgot your password?</a></p>
        </div>
    </div>
</body>
</html>
