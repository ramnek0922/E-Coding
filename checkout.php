<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>PayMongo Payment</title>
  <style>
    /* General Reset */
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }


    body {
      font-family: Arial, sans-serif;
      background-color: #8fe5a9; /* Black background */
      color: #fff; /* White text */
      display: flex;
      justify-content: center;
      align-items: center;
      height: 100vh;
    }


    .payment-container {
      background-color: #1c1c1c; /* Dark gray for the form */
      padding: 20px;
      border-radius: 8px;
      width: 100%;
      max-width: 400px;
      box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.5);
    }


    .payment-container h2 {
      margin-bottom: 20px;
      text-align: center;
      font-size: 24px;
    }


    .form-group {
      margin-bottom: 15px;
    }


    .form-group label {
      display: block;
      margin-bottom: 5px;
      font-size: 14px;
      color: #ccc; /* Light gray for labels */
    }


    .form-group input {
      width: 100%;
      padding: 10px;
      border: 1px solid #444; /* Dark border */
      border-radius: 5px;
      background-color: #333; /* Input background */
      color: #fff; /* White text */
    }


    .form-group input:focus {
      outline: none;
      border-color: #555; /* Slightly brighter border on focus */
    }


    .submit-btn {
      width: 100%;
      padding: 10px;
      border: none;
      border-radius: 5px;
      background-color: green; /* Blue button */
      color: #fff;
      font-size: 16px;
      cursor: pointer;
      transition: background-color 0.3s;
    }


    .submit-btn:hover {
      background-color: yellow; /* Darker blue on hover */
    }
  </style>
</head>
<body>
  <div class="payment-container">
    <h2>Pay with PayMongo</h2>
    <form action="process_paymongo.php" method="POST">
      <div class="form-group">
        <label for="name">Cardholder Name</label>
        <input type="text" id="name" name="name" required value="Elon Musk">
      </div>
      <div class="form-group">
        <label for="email">Email Address</label>
        <input type="email" id="email" name="email" required value="elonmusk@gmail.com">
      </div>
      <div class="form-group">
        <label for="card_number">Card Number</label>
        <input type="text" id="card_number" name="card_number" maxlength="16" required value="5240050000001440">
      </div>
      <div class="form-group">
        <label for="expiry">Expiry Date (MM/YY)</label>
        <input type="text" id="expiry" name="expiry" required value="12/34">
      </div>
      <div class="form-group">
        <label for="cvv">CVV</label>
        <input type="text" id="cvv" name="cvv" maxlength="3" required value="123">
      </div>
      <input type="hidden" name="amount" value="2000"> <!-- Hidden field for PHP 20.00 -->
      <button type="submit" class="submit-btn">Pay Now</button>
    </form>
  </div>
</body>
</html>
