<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if a session is already started
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "final_projectdb";

// Database connection
$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Initialize user info array
$userInfo = [
    'username' => '',
    'email' => '',
    'full_name' => '',
    'address' => '',
    'phone_number' => '',
    'recovery_email' => '',
    'profilePicture' => ''
];

// Fetch user info from the database if the user is logged in
if (isset($_SESSION['username'])) {
    $username = $_SESSION['username'];
    $stmt = $conn->prepare("SELECT username, email, full_name, address, phone_number, recovery_email, profilePicture FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $userInfo = $result->fetch_assoc();
    }
    $stmt->close();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $full_name = $_POST['full_name'];
    $address = $_POST['address'];
    $phone_number = $_POST['phone_number'];
    $recovery_email = $_POST['recovery_email'];
    $password = $_POST['password'];
    $profilePicture = $_FILES['profilePicture']['name'];
    $target_file = $userInfo['profilePicture']; // Default to existing picture

    // Handle profile picture upload
    if ($profilePicture) {
        $target_dir = "uploads/";
        if (!is_dir($target_dir)) {
            mkdir($target_dir, 0777, true);
        }
        $target_file = $target_dir . basename($profilePicture);
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
        $uploadOk = 1;

        // Check if file is an actual image
        $check = getimagesize($_FILES["profilePicture"]["tmp_name"]);
        if ($check !== false) {
            // Check file size
            if ($_FILES["profilePicture"]["size"] > 5000000) {
                $error_message = "Sorry, your file is too large.";
                $uploadOk = 0;
            }
            // Allow certain file formats
            if (!in_array($imageFileType, ['jpg', 'jpeg', 'png', 'gif'])) {
                $error_message = "Sorry, only JPG, JPEG, PNG, and GIF files are allowed.";
                $uploadOk = 0;
            }
        } else {
            $error_message = "File is not an image.";
            $uploadOk = 0;
        }

        // Check if $uploadOk is set to 0 by an error
        if ($uploadOk == 1) {
            if (move_uploaded_file($_FILES["profilePicture"]["tmp_name"], $target_file)) {
                $target_file = $target_dir . basename($profilePicture);
            } else {
                $error_message = "Sorry, there was an error uploading your file.";
            }
        }
    }

    // Update user info in the database
    if (!empty($password)) {
        $password_hash = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("UPDATE users SET email=?, full_name=?, address=?, phone_number=?, recovery_email=?, password=?, profilePicture=? WHERE username=?");
        $stmt->bind_param("ssssssss", $email, $full_name, $address, $phone_number, $recovery_email, $password_hash, $target_file, $_SESSION['username']);
    } else {
        $stmt = $conn->prepare("UPDATE users SET email=?, full_name=?, address=?, phone_number=?, recovery_email=?, profilePicture=? WHERE username=?");
        $stmt->bind_param("sssssss", $email, $full_name, $address, $phone_number, $recovery_email, $target_file, $_SESSION['username']);
    }

    if ($stmt->execute()) {
        $_SESSION['success_message'] = "Profile updated successfully!";
        header("Location: edit_profile.php");
        exit();
    } else {
        $error_message = "Error updating profile: " . $stmt->error;
    }
    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            /* height: 100vh; */ 
            max-height: 900px;
            background: linear-gradient(135deg, #007A33, #00A34F);
        }

        .profile-container {
            width: 90%;
            max-width: 800px;
            max-height: 900px;
            margin: 20px auto;
            padding: 20px;
            background-color: #ffffff;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .profile-picture {
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .profile-picture img {
            border-radius: 50%;
            width: 150px;
            height: 150px;
            object-fit: cover;
            border: 3px solid #007A33;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        .upload-overlay {
            display: none;
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            background-color: rgba(0, 0, 0, 0.5);
            color: #fff;
            text-align: center;
            border-radius: 50%;
            padding: 10px;
            cursor: pointer;
        }

        .profile-picture:hover .upload-overlay {
            display: block;
        }

        .upload-overlay input[type="file"] {
            display: none;
        }

        .profile-details h1 {
            font-size: 24px;
            margin: 10px 0;
        }

        .form-group {
            margin-bottom: 15px;
            text-align: left;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="email"],
        .form-group input[type="password"],
        .form-group input[type="tel"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 5px;
            box-sizing: border-box;
        }

        .btn {
            padding: 10px 20px;
            background-color: #FFD700; 
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            width: 100%;
            font-size: 16px;
            margin-top: 10px;
        }

        .btn:hover {
            background-color: #005a25;
        }

        .alert {
            padding: 10px;
            background-color: #f44336;
            color: white;
            margin-bottom: 15px;
            border-radius: 5px;
        }

        .alert-success {
            background-color: #4CAF50;
        }

        .alert-danger {
            background-color: #f44336;
        }

        .btn-back {
            background-color: #007A33;
            margin-bottom: 10px;
        }

        .btn-back:hover {
            background-color: #666;
        }
    </style>
</head>
<body>
    <div class="profile-container">
        <h1>Edit Profile</h1>
        <?php if (!empty($error_message)): ?>
            <div class="alert alert-danger">
                <?php echo $error_message; ?>
            </div>
        <?php endif; ?>
        <?php if (!empty($_SESSION['success_message'])): ?>
            <div class="alert alert-success">
                <?php 
                echo $_SESSION['success_message']; 
                unset($_SESSION['success_message']); // Unset the message after displaying it
                ?>
            </div>
        <?php endif; ?>

        <form action="edit_profile.php" method="POST" enctype="multipart/form-data">
            <div class="profile-picture">
                <img src="<?php echo htmlspecialchars($userInfo['profilePicture'] ? $userInfo['profilePicture'] : 'uploads/default.jpg'); ?>" alt="Profile Picture">
                <div class="upload-overlay">
                    <label for="profilePicture">Change Picture</label>
                    <input type="file" id="profilePicture" name="profilePicture" accept="image/*">
                </div>
            </div>
            <div class="form-group">
                <label for="email">Email:</label>
                <input type="email" name="email" value="<?php echo htmlspecialchars($userInfo['email']); ?>">
            </div>
            <div class="form-group">
                <label for="full_name">Full Name:</label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($userInfo['full_name']); ?>">
            </div>
            <div class="form-group">
                <label for="address">Address:</label>
                <input type="text" name="address" value="<?php echo htmlspecialchars($userInfo['address']); ?>">
            </div>
            <div class="form-group">
                <label for="phone_number">Phone Number:</label>
                <input type="tel" name="phone_number" value="<?php echo htmlspecialchars($userInfo['phone_number']); ?>">
            </div>
            <div class="form-group">
                <label for="recovery_email">Recovery Email:</label>
                <input type="email" name="recovery_email" value="<?php echo htmlspecialchars($userInfo['recovery_email']); ?>">
            </div>
            <div class="form-group">
                <label for="password">New Password (leave blank to keep current password):</label>
                <input type="password" name="password">
            </div>
            <button type="submit" class="btn">Save Changes</button>
        </form>

        <form action="index.php" method="get">
            <button type="submit" class="btn btn-back">Return</button>
        </form>
    </div>
</body>
</html>
