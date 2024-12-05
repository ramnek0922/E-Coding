<?php
// Start session at the very beginning
session_start();

// Debugging session variables
error_log(print_r($_SESSION, true)); // Log session variables

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
} else {
    session_regenerate_id(true); // Regenerate session ID to prevent fixation
}

// Initialize the cart if not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
if (!isset($cartHandlerIncluded)) {
    $cartHandlerIncluded = true;
    include 'cart_handler.php'; // Ensure this logic executes only once
}
// Add to Cart logic
if (isset($_POST['add_to_cart'])) {
    $toyId = $_POST['toy_id'];

    // Sample list of toys (replace with your database or dynamic data)
    $toys = [
        1 => ['name' => 'Rocket Launcher', 'price' => 350, 'image' => 'uploads/rcb1.jpg'],
        2 => ['name' => 'Super Hero Action Figure', 'price' => 999, 'image' => 'uploads/af.jpg'],
        3 => ['name' => 'Wooden Puzzle', 'price' => 659, 'image' => 'uploads/wp.jpg'],
        4 => ['name' => 'Glow in the Dark Dinosaurs', 'price' => 359, 'image' => 'uploads/gd.jpg'],
    ];

    // Ensure the toy exists before adding to cart
    if (isset($toys[$toyId])) {
        // Add item to the cart
        $_SESSION['cart'][] = $toys[$toyId]; // Add toy to cart session
    }
}

// Debugging session variables to check cart contents
error_log(print_r($_SESSION['cart'], true)); // Log cart details
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Welcome E-Coding Toy Store!</title>
    <!-- AdminLTE CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <!-- Custom Styles -->
    <style>
        body {
            background: linear-gradient(135deg, #007A33, #00A34F); /* Light sky blue for a cheerful atmosphere */
            font-family: 'Comic Sans MS', cursive, sans-serif; /* Fun, playful font */
        }
        .brand-link {
            background: linear-gradient(135deg, #007A33, #00A34F); /* Bright pink for toy store theme */
            color: white !important;
            font-weight: bold;
            font-size: 30px;
            text-align: center;
            padding: 20px;
            border-radius: 10px;
        }
        .main-footer {
            background: linear-gradient(135deg, #007A33, #00A34F); /* Light orange footer */
            color: white;
            text-align: center;
            padding: 10px;
            font-size: 16px;
        }
        .content-wrapper {
            background: #8fe5a9; /* Soft yellow for a playful vibe */
            padding: 40px;
            border-radius: 10px;
        }
        .alert {
            background-color: #b1e9b8; /* Highlight box color */
            color: black;
            border-radius: 10px;
            padding: 20px;
            font-size: 18px;
            font-weight: bold;
        }
        .search-bar {
            display: flex;
            justify-content: center;
            margin-top: 20px;
            margin-bottom: 30px;
        }
        .search-bar input {
            padding: 15px;
            width: 60%;
            border-radius: 15px;
            border: 2px solid #ff4081;
            font-size: 16px;
            margin-right: 10px;
        }
        .search-bar button {
            padding: 15px 20px;
            border: none;
            background-color: #ff4081;
            color: white;
            border-radius: 15px;
            font-size: 16px;
            cursor: pointer;
        }
        .search-bar button:hover {
            background-color: #f50057;
        }
        .cart-icon {
            position: fixed;
            top: 20px;
            right: 20px;
            font-size: 30px;
            background-color: #33cc4f;
            color: white;
            padding: 15px;
            border-radius: 50%;
            cursor: pointer;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }
        .cart-icon:hover {
            background-color: yellow;
        }
        .cart-icon .badge {
            position: absolute;
            top: 0;
            right: 0;
            background-color: white;
            color: black;
            border-radius: 50%;
            padding: 5px 10px;
            font-weight: bold;
        }
        .toy-container {
            display: grid;
            grid-template-columns: repeat(2, 1fr); /* Show 2 items per row */
            gap: 20px;
            margin-top: 40px;
        }
        .toy-item {
            background-color: white;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            text-align: center;
            position: relative;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
        .toy-item img {
            width: 100%;
            height: 350px;
            object-fit: cover;
            border-radius: 10px;
        }
        .toy-item:hover {
            transform: translateY(-10px);
            box-shadow: 0px 10px 30px rgba(0, 0, 0, 0.15);
        }
        .toy-item h4 {
            margin-top: 15px;
            font-size: 22px;
            color: #ff4081;
        }
        .toy-item p {
            color: #ff6f00;
            font-size: 18px;
            margin: 10px 0;
        }
        .toy-item button {
            padding: 15px 25px;
            background-color: green;
            color: white;
            border: none;
            border-radius: 10px;
            cursor: pointer;
            font-size: 18px;
            transition: background-color 0.3s ease;
        }
        .toy-item button:hover {
            background-color: yellow;
        }
        /* Sale Banner */
        .sale-banner {
            position: absolute;
            top: 10px;
            left: 10px;
            background-color: red;
            color: white;
            padding: 10px;
            font-size: 18px;
            font-weight: bold;
            border-radius: 5px;
            text-transform: uppercase;
        }
    </style>
</head>
<body class="hold-transition sidebar-mini">
    
<div class="wrapper">
    <!-- Navbar -->
    <?php include 'menu.php'; ?> <!-- Include your redesigned toy store menu -->

    <!-- Content Wrapper -->
    <div class="content-wrapper">
        <section class="content">

                <?php
                // Handle different page requests
                $page = $_GET['page'] ?? 'home'; // Default to home page
                switch ($page) {
                    case 'view_toys':
                        include 'view_toys.php';
                        break;
                    case 'orders':
                        include 'orders.php';
                        break;
                    case 'shipping':
                        include 'shipping_method.php';
                        break;
                    case 'profile':
                        include 'profile.php';
                        break;
                    case 'contact':
                        include 'contact.php';
                        break;
                    default:
                        echo '
                        <div class="alert text-center">
                            <h2>Welcome to E-Coding Toy Store!</h2>
                            <p>Your one-stop shop for fun and games. Explore a variety of toys, manage your profile, or check your orders.</p>
                        </div>';
                        
                        // Display 4 toys with a Sale banner
                        echo '<div class="toy-container">';
                        
                            echo '
                            <div class="toy-item">
                                <div class="sale-banner">Sale</div>
                                <img src="uploads/rcb1.jpg" alt="Toy 1" style="width: 100%; height: auto;">
                                <h4>Rocket Launcher</h4>
                                <h7>was : 500.00<h7>
                                <p>Now: 350.00 PHP</p>
                                <form method="post" action="">
    <input type="hidden" name="toy_id" value="1"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>

                                </div>';

                            echo '
                            <div class="toy-item">
                                <div class="sale-banner">Sale</div>
                                <img src="uploads/af.jpg" alt="Toy 1" style="width: 100%; height: auto;">
                                <h4>Super Hero Action Figure</h4>
                                <h7>was : 1199.00<h7>
                                <p>Now: 999.00 PHP</p>
                                <form method="post" action="">
    <input type="hidden" name="toy_id" value="2"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>
                                </div>';

                                echo '
                                <div class="toy-item">
                                    <div class="sale-banner">Sale</div>
                                    <img src="uploads/wp.jpg" alt="Toy 1" style="width: 100%; height: auto;">
                                    <h4>Wooden Puzzle</h4>
                                    <h7>was : 899.00<h7>
                                    <p>Now: 659.00 PHP</p>
                                    <form method="post" action="">
    <input type="hidden" name="toy_id" value="3"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>
                                    </div>';

                                    echo '
                                    <div class="toy-item">
                                        <div class="sale-banner">Sale</div>
                                        <img src="uploads/gd.jpg" alt="Toy 1" style="width: 100%; height: auto;">
                                        <h4>Glow in the Dark Dinosaurs</h4>
                                        <h7>was : 499.00<h7>
                                        <p>Now: 359.00 PHP</p>
                                        <form method="post" action="">
    <input type="hidden" name="toy_id" value="4"> <!-- Toy ID -->
    <button type="submit" name="add_to_cart">Add to Cart</button>
</form>
                                        </div>';
                       
                       
                        echo '</div>';
                        break;
                }
                ?>
            </div>
        </section>
    </div>

    <!-- Cart Icon -->
    <a href="cart.php" class="cart-icon" title="View Cart">
        <i class="fas fa-shopping-cart"></i>
        <?php if (count($_SESSION['cart']) > 0): ?>
            <span class="badge"><?= count($_SESSION['cart']); ?></span>
        <?php endif; ?>
    </a>

    <!-- Main Footer -->
    <footer class="main-footer">
        <strong>&copy; 2024 E-Coding Toy Store.</strong> All rights reserved.
        <div class="float-right d-none d-sm-inline-block">
            <b>Version</b> 1.0
        </div>
    </footer>
</div>

<!-- AdminLTE JS -->
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
