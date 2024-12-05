<?php
// Start session if not already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Initialize success message variable
$successMessage = "";

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = htmlspecialchars($_POST['name']);
    $email = htmlspecialchars($_POST['email']);
    $message = htmlspecialchars($_POST['message']);

    // Simulate message sending
    $successMessage = "Thank you for reaching us. We would return to your message shortly.";
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            background-color: #f0f8ff;
            font-family: 'Comic Sans MS', cursive, sans-serif;
        }
        .contact-form {
            background-color: #fffbe6;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            margin: 20px auto;
            max-width: 600px;
        }
        .contact-form h2 {
            text-align: center;
            color: green;
            margin-bottom: 20px;
        }
        .form-control {
            margin-bottom: 20px;
            padding: 15px;
            border-radius: 10px;
            border: 2px solid #8fe5a9;
        }
        .btn-submit {
            background-color: green;
            color: white;
            padding: 15px;
            border: none;
            border-radius: 10px;
            font-size: 18px;
            width: 100%;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .btn-submit:hover {
            background-color: #f50057;
        }
        .success-message {
            color: green;
            font-weight: bold;
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Include the menu -->

        <div class="content-wrapper">
            <section class="content">
                <div class="contact-form">
                    <h2>Contact Us</h2>
                    <!-- Display success message -->
                    <?php if (!empty($successMessage)): ?>
                        <div class="success-message"><?= $successMessage; ?></div>
                    <?php endif; ?>
                    <form method="post" action="">
                        <input type="text" name="name" class="form-control" placeholder="Your Name" required>
                        <input type="email" name="email" class="form-control" placeholder="Your Email" required>
                        <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
                        <button type="submit" class="btn-submit">Send Message</button>
                    </form>
                </div>
            </section>
        </div>
        <footer class="main-footer">
            <strong>&copy; 2024 E-Coding Toy Store.</strong> All rights reserved.
        </footer>
    </div>
</body>
</html>
