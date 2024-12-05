<?php

// Initialize the cart if not already initialized
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Add to Cart functionality
if (isset($_POST['add_to_cart'])) {
    $toyId = $_POST['toy_id'];

    // Sample list of toys (replace with your database or dynamic data)
    $toys = [
        1 => ['name' => 'Rocket Launcher', 'price' => 350, 'image' => 'uploads/rcb1.jpg'],
        2 => ['name' => 'Super Hero Action Figure', 'price' => 999, 'image' => 'uploads/af.jpg'],
        3 => ['name' => 'Wooden Puzzle', 'price' => 659, 'image' => 'uploads/wp.jpg'],
        4 => ['name' => 'Glow in the Dark Dinosaurs', 'price' => 359, 'image' => 'uploads/gd.jpg'],
        5 => ['name' => 'Bouncy Ball', 'price' => 199.00, 'image' => 'uploads/bb.jpg'],
        6 => ['name' => 'Mega Construction Blocks', 'price' => 999.00, 'image' => 'uploads/blocks.jpg'],
        7 => ['name' => 'Space Explorer Set', 'price' => 2399.00, 'image' => 'uploads/space.jpg'],
        8 => ['name' => 'Super Slime Kit', 'price' => 350.00, 'image' => 'uploads/slime.jpg'],
        9 => ['name' => 'Dollhouse with Furniture', 'price' => 2599.00, 'image' => 'uploads/doll.jpg'],
        10 => ['name' => 'Interactive Plush Unicorn', 'price' => 1499.00, 'image' => 'uploads/gd.jpg'],
        11 => ['name' => 'Adventure Kit', 'price' => 350.00, 'image' => 'uploads/ak.jpg'],
        12 => ['name' => 'Animal Kingdom', 'price' => 599.00, 'image' => 'uploads/animal.jpg'],
    ];
 
    // Ensure the toy exists before adding to cart
    if (isset($toys[$toyId])) {
        // Add item to the cart
        $_SESSION['cart'][] = $toys[$toyId];
    }
    if (isset($_POST['add_to_cart'])) {
        $toyId = $_POST['toy_id'];
        // Add to cart logic here...
    
        // Redirect to avoid resubmitting form
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
