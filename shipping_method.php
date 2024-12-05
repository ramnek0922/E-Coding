<?php
// Database connection
$host = 'localhost';
$dbname = 'final_projectdb';
$user = 'root';
$pass = '';

try {
    $pdo = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $order_id = $_POST['order_id'];
    $shipping_method = $_POST['shipping_method'];
    $shipping_status = $_POST['shipping_status'];

    $stmt = $pdo->prepare("UPDATE orders SET shipping_method = ?, shipping_status = ? WHERE id = ?");
    $stmt->execute([$shipping_method, $shipping_status, $order_id]);
    $message = "Order updated successfully!";
}

// Fetch orders from the database
$stmt = $pdo->query("SELECT id, product_name, shipping_method, shipping_status FROM orders");
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Shipping Method - E-Coding Toy Store</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
</head>
<body>
    <div class="content-wrapper">
        <section class="content">
            <div class="container">
                <div class="alert text-center">
                    <h2>Choose Your Shipping Method</h2>
                    <p>Ensure your toys arrive quickly and safely!</p>
                </div>

                <!-- Shipping Form -->
                <form class="shipping-form">
                    <div class="form-group">
                        <label for="address">Shipping Address:</label>
                        <input type="text" name="address" id="address" class="form-control" placeholder="Enter your address" required>
                    </div>

                    <!-- Tabs for Shipping Options -->
                    <ul class="nav nav-tabs" id="shippingTabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="standard-tab" data-toggle="tab" href="#standard" role="tab" aria-controls="standard" aria-selected="true">Standard Delivery</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="express-tab" data-toggle="tab" href="#express" role="tab" aria-controls="express" aria-selected="false">Express Delivery</a>
                        </li>
                    </ul>

                    <!-- Tab Content -->
                    <div class="tab-content" id="shippingTabsContent">
                        <div class="tab-pane fade show active" id="standard" role="tabpanel" aria-labelledby="standard-tab">
                            <h5>Standard Delivery</h5>
                            <p>Delivery time: 3-5 days</p>
                            <p>Cost: 50 PHP</p>
                        </div>
                        <div class="tab-pane fade" id="express" role="tabpanel" aria-labelledby="express-tab">
                            <h5>Express Delivery</h5>
                            <p>Delivery time: 1-2 days</p>
                            <p>Cost: 150 PHP</p>
                        </div>
                    </div>

                    <!-- Confirm Button -->
                    <button type="button" class="btn btn-success btn-lg" id="confirm-btn">Confirm</button>
                </form>

                <!-- Success Message -->
                <div id="success-message" class="alert alert-success mt-3" style="display: none;">
                    <strong>Success!</strong> Shipping fee added.
                </div>
            </div>
        </section>
    </div>

    <!-- Custom Styles -->
    <style>
        .shipping-form {
            background-color: #fffbe6;
            padding: 30px;
            border-radius: 15px;
            box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group label {
            font-size: 18px;
            color: black;
        }

        .form-control {
            padding: 15px;
            border: 2px solid #8fe5a9;
            border-radius: 10px;
            font-size: 16px;
        }

        .btn-success {
            background-color: green;
            border: none;
            border-radius: 15px;
            font-size: 18px;
            width: 100%;
        }

        .btn-success:hover {
            background-color: #f50057;
        }
    </style>

    <!-- JavaScript -->
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.5.4/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script>
        document.getElementById('confirm-btn').addEventListener('click', function() {
            var address = document.getElementById('address').value;
            var shippingOption = document.querySelector('.nav-link.active').textContent;

            if (!address) {
                alert('Please enter your shipping address!');
                return;
            }

            // Display Confirmation
            var confirmation = confirm('Are you sure you want to proceed with this shipping method?\n\nAddress: ' + address + '\nShipping Method: ' + shippingOption);
            // Display success message
            var successMessage = document.getElementById('success-message');
            successMessage.style.display = 'block';
            successMessage.innerHTML = '<strong>Success!</strong> Shipping fee for ' + shippingOption + ' has been added.';
        });
    </script>
</body>
</html>