<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['loggedin']) || $_SESSION['loggedin'] !== true) {
    header('Location: login.php');
    exit;
}

// Initialize the cart if not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shopping Cart</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/css/adminlte.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        /* You can add your custom styles here */
    </style>
</head>
<body class="hold-transition sidebar-mini">

<div class="wrapper">
    <!-- Navbar -->
    <?php include 'menu.php'; ?> <!-- Include your menu here -->

    <div class="content-wrapper">
        <section class="content">
            <div class="container-fluid">
                <h2>Your Cart</h2>

                <!-- Check if cart is empty -->
                <?php if (empty($_SESSION['cart'])): ?>
                    <div class="alert alert-warning text-center">
                        <p>Your cart is empty!</p>
                    </div>
                <?php else: ?>
                    <!-- Display cart items -->
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Item</th>
                                <th>Price</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($_SESSION['cart'] as $index => $item): ?>
                                <tr>
                                    <td><?= $item['name'] ?></td>
                                    <td><?= number_format($item['price'], 2) ?> PHP</td>
                                    <td>
                                        <!-- Option to remove item from cart -->
                                        <form action="remove_from_cart.php" method="POST">
                                            <input type="hidden" name="index" value="<?= $index ?>">
                                            <button type="submit" class="btn btn-danger">Remove</button>
                                        </form>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>

                    <!-- Cart Total -->
                    <div class="text-right">
                        <h4>Total: 
                            <?php 
                            $total = 0;
                            foreach ($_SESSION['cart'] as $item) {
                                $total += $item['price'];
                            }
                            echo number_format($total, 2) . ' PHP';
                            ?>
                        </h4>
                    </div>

                    <!-- Checkout Button (Optional) -->
                    <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
                <?php endif; ?>
            </div>
        </section>
    </div> 

    <footer class="main-footer">
        <strong>&copy; 2024 E-Coding Toy Store.</strong> All rights reserved.
    </footer>
</div>

<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2.0/dist/js/adminlte.min.js"></script>
</body>
</html>
