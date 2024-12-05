<?php
session_start();

$login_error = '';
$success_message = '';

// Check for password reset success message
if (isset($_SESSION['password_reset_success'])) {
$success_message = $_SESSION['password_reset_success'];
unset($_SESSION['password_reset_success']);
}

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
$password = trim($_POST['password']);

// Validate input
if (empty($username) || empty($password)) {
$login_error = 'Username and password are required.';
} else {
$stmt = $conn->prepare("SELECT * FROM users WHERE username = ?");
$stmt->bind_param("s", $username);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows == 1) {
$user = $result->fetch_assoc();
if (password_verify($password, $user['password'])) {
$_SESSION['loggedin'] = true;
$_SESSION['username'] = $username;
session_regenerate_id(true); // Regenerate session ID on login
header('Location: index.php');
exit;
} else {
$login_error = 'Invalid username or password.';
}
} else {
$login_error = 'Invalid username or password.';
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
        <title>Login</title>
    <style>
    body, html {
        height: 100%;
        margin: 0;
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: Arial, sans-serif;
        background: linear-gradient(135deg, #16A085, #F4D03F); /*Gradient Color*/
        }
    .container {
        display: flex;
        width: 100%; /* Adjust the width as needed */
        max-width: 900px; /* Adjust the max-width as needed */
        height: 80%;
        max-height: 600px;
        box-shadow: 0 0 15px rgba(0,0,0,0.2);
        border-radius: 10px;
        overflow: hidden;
    }
.welcome-section {
flex: 0 0 45%;
background: linear-gradient(135deg, #007A33, #00A34F);
display: flex;
flex-direction: column;
align-items: center;
justify-content: center;
color: #fff;
text-align: center;
padding: 40px;
}
.welcome-section h1 {
font-size: 48px;
margin: 0;
text-transform: uppercase;
letter-spacing: 2px;
}
.welcome-section h1:nth-of-type(2) {
font-size: 40px;
margin: 20px 0 0;
color: #FFD700;
}
.welcome-section .logo {
font-size: 20px;
margin: 10px 0;
font-weight: normal;
}
.welcome-section p {
font-size: 18px;
margin: 20px 0 0;
}
.login-form {
flex: 1;
background: #fff;
padding: 40px;
display: flex;
flex-direction: column;
justify-content: center;
}
.login-form h2 {
margin-bottom: 20px;
font-size: 28px;
color: #007A33;
}
.login-form form {
display: flex;
flex-direction: column;
}
.login-form input[type="text"], .login-form input[type="password"] {
padding: 12px;
margin-bottom: 20px;
border: 1px solid #ccc;
border-radius: 5px;
font-size: 16px;
box-sizing: border-box;
}
.login-form button {
padding: 12px;
background-color: #007A33;
color: #fff;
border: none;
border-radius: 5px;
cursor: pointer;
font-size: 16px;
}
.login-form button:hover {
background-color: #005A23;
}
.login-form .remember-me {
display: flex;
align-items: center;
margin-bottom: 20px;
}
.login-form .remember-me input {
margin-right: 10px;
}
.login-form .additional-links a {
color: #007A33;
text-decoration: none;
}
.login-form .additional-links a:hover {
text-decoration: underline;
}
.text-danger {
color: #ff0000;
text-align: center;
}
</style>
</head>
<body>
<div class="container">
<div class="welcome-section">
<h1>Welcome Back</h1>
<h1>E-Coding</h1>
<div class="logo">Toy Store</div>
<p>Please login to your account</p>
</div>
<div class="login-form">
<h2>Login</h2>
<?php if ($login_error != ''): ?>
<p class="text-danger"><?= htmlspecialchars($login_error) ?></p>
<?php endif; ?>
<form action="login.php" method="post">
<input type="text" name="username" placeholder="Username" required>
<input type="password" name="password" placeholder="Password" required>
<div class="remember-me">
<input type="checkbox" id="remember" name="remember">
<label for="remember">Remember Me</label>
</div>
<button type="submit">Login</button>
</form>
<div class="additional-links">
<p><a href="forgot_password.php">Forgot Password?</a></p>
<p><a href="register.php">Sign up</a></p>
</div>
</div>
</div>
</body>
</html>