<?php
// Enable error reporting
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Start session at the very beginning
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
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

$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Profile</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 80vh;
            background-color: #f4f6f9;
        }
        .profile-card {
            background-color: #fff;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            max-width: 500px;
            text-align: center;
        }
        .profile-picture img {
            border-radius: 50%;
            width: 120px;
            height: 120px;
            object-fit: cover;
        }
        .profile-details h1 {
            font-size: 24px;
            margin-top: 15px;
            color: #333;
        }
        .profile-details p {
            color: #666;
            margin-bottom: 10px;
        }
        .btn-container .btn {
            background-color: #005a25;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            margin-top: 15px;
            transition: background-color 0.3s ease;
        }
        .btn-container .btn:hover {
            background-color: #0056b3;
        }
        footer {
            text-align: center;
            padding: 20px;
            background-color: #f4f6f9;
            position: fixed;
            width: 100%;
            bottom: 0;
        }
        footer .footer-links a {
            color: #007bff;
            text-decoration: none;
            font-weight: bold;
            margin: 0 10px;
            cursor: pointer;
        }
        footer .footer-links a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
<div class="wrapper">
    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <div class="profile-container">
                    <div class="profile-card">
                        <div class="profile-picture">
                            <img src="<?php echo htmlspecialchars($userInfo['profilePicture'] ? $userInfo['profilePicture'] : 'uploads/default.jpg'); ?>" alt="Profile Picture">
                        </div>
                        <div class="profile-details">
                            <h1><?php echo htmlspecialchars($userInfo['full_name']); ?></h1>
                            <p>Username: <?php echo htmlspecialchars($userInfo['username']); ?></p>
                            <p>Email: <?php echo htmlspecialchars($userInfo['email']); ?></p>
                            <p>Address: <?php echo htmlspecialchars($userInfo['address']); ?></p>
                            <p>Phone: <?php echo htmlspecialchars($userInfo['phone_number']); ?></p>
                            <p>Recovery Email: <?php echo htmlspecialchars($userInfo['recovery_email']); ?></p>
                            <div class="btn-container">
                                <button class="btn" onclick="window.location.href='edit_profile.php'">Edit Profile</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<!-- Footer Section -->
<footer>
    <div class="footer-links">
        <a data-toggle="modal" data-target="#companyModal">E-Coding</a>
        <a data-toggle="modal" data-target="#aboutModal">About E-Coding Toy Store</a>
        <a data-toggle="modal" data-target="#ethicsModal">E-Coding Toy Store Ethics</a>
        <a data-toggle="modal" data-target="#contactModal">Contact Us</a>
    </div>
</footer>

<!-- Modals -->
<div class="modal fade" id="companyModal" tabindex="-1" role="dialog" aria-labelledby="companyModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="companyModalLabel">E-Coding</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                E-Coding is the name behind the creation and development of E-Coding Toy Store, 
                an e-commerce platform dedicated to offering high-quality toys for children. With
                expertise in technology and education, E-Coding's mission is to combine the joy of 
                play with meaningful learning, providing a one of a kind online shopping experience 
                that parents and childrends can trust.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="aboutModal" tabindex="-1" role="dialog" aria-labelledby="aboutModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="aboutModalLabel">About E-Coding Toy Store</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                E-Coding Toy Store is dedicated to providing high-quality toys for kids and
                adults alike. Our mission is to foster creativity and learning through interactive, 
                engaging products. Whether its through coding robots, puzzle games, or building
                kits, our goal is to make our toy products an exciting adventure for children of all ages.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="ethicsModal" tabindex="-1" role="dialog" aria-labelledby="ethicsModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ethicsModalLabel">E-Coding Toy Store Ethics</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                We are committed to ethical business practices, ensuring all our products 
                are sourced responsibly and produced with the highest standards of safety
                and quality. Customer satisfaction and trust are at the core of our values.
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="contactModal" tabindex="-1" role="dialog" aria-labelledby="contactModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="contactModalLabel">Contact Us</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                If you have questions, please contact us at Phone (09267845610), Telephone (55-39-309).
            </div>
        </div>
    </div>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>

