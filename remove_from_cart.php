<?php
session_start();

// Ensure the cart is initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Check if the 'index' field is set in the POST request
if (isset($_POST['index'])) {
    $index = intval($_POST['index']); // Convert index to integer

    // Check if the index is valid
    if (isset($_SESSION['cart'][$index])) {
        unset($_SESSION['cart'][$index]); // Remove the item from the cart
        $_SESSION['cart'] = array_values($_SESSION['cart']); // Reindex array to avoid gaps
    }
}

// Redirect back to the cart page
header('Location: cart.php');
exit;
?>
