
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Order</title>
    <style>
        table {
            width: 50%;
            margin: auto;
            border-collapse: collapse;
        }
        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: center;
        }
        table th {
            background-color: #f4f4f4;
        }
        button {
            margin: 10px;
            padding: 8px 15px;
            background-color: #4CAF50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <div style="text-align: center;">
        <?php
        // Check if the cart exists and is not empty
        if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
            echo "<p>Your cart is empty.</p>";
        } else {
            echo "<h2>Your Order</h2>";
            echo "<table>";
            echo "<tr><th>Item</th><th>Price</th></tr>";

            // Loop through the cart and display items
            $total = 0;
            foreach ($_SESSION['cart'] as $item) {
                echo "<tr>";
                echo "<td>{$item['name']}</td>";
                echo "<td>" . number_format($item['price'], 2) . " PHP</td>";
                echo "</tr>";
                $total += $item['price'];
            }

            echo "<tr><td><strong>Total</strong></td><td><strong>" . number_format($total, 2) . " PHP</strong></td></tr>";
            echo "</table>";
        }

        // Handle clear cart or checkout actions
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (isset($_POST['clear_cart'])) {
                unset($_SESSION['cart']);
                echo "<p>Your cart has been cleared.</p>";
            }

            if (isset($_POST['checkout'])) {
                echo "<p>Thank you for your order!</p>";
                // Add your checkout logic here (e.g., redirect to payment page)
            }
        }
        ?>
        <form method="post" action="">

        <a href="checkout.php" style="
    display: inline-block;
    padding: 10px 20px;
    font-size: 16px;
    color: white;
    background-color: #4CAF50;
    text-decoration: none;
    border: none;
    border-radius: 5px;
    cursor: pointer;
    transition: background-color 0.3s ease;"
    onmouseover="this.style.backgroundColor='#45a049';" 
    onmouseout="this.style.backgroundColor='#4CAF50';">
    Checkout
</a>

        </form>
    </div>
</body>
</html>
