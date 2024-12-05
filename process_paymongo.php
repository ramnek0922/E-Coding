<?php
// Start session for error handling (optional)
session_start();


// PayMongo Secret Key
$paymongo_secret_key = 'sk_test_5vD3LpgBVR3wcFaMhzDE4EG2';


// Capture form data
$name = $_POST['name'];
$email = $_POST['email'];
$card_number = $_POST['card_number'];
$expiry = $_POST['expiry'];
$cvv = $_POST['cvv'];
$amount_in_cents = $_POST['amount']; // Use the hidden amount field from the form


// Validate form data
if (empty($name) || empty($email) || empty($card_number) || empty($expiry) || empty($cvv)) {
    die("All fields are required!");
}


// Split expiry date into month and year
list($exp_month, $exp_year) = explode('/', $expiry);


// Format the expiry year to 4 digits
$exp_year = "20" . $exp_year;


// Step 1: Create a PaymentIntent
$payment_intent_url = 'https://api.paymongo.com/v1/payment_intents';
$payment_data = [
    'data' => [
        'attributes' => [
            'amount' => (int)$amount_in_cents, // Ensure it's an integer
            'payment_method_allowed' => ['card'],
            'currency' => 'PHP',
            'description' => 'Payment for Order #12345',
        ]
    ]
];


$payment_intent_response = api_request($payment_intent_url, $payment_data, $paymongo_secret_key);


// Check for PaymentIntent creation errors
if (isset($payment_intent_response['errors'])) {
    die("PaymentIntent creation failed: " . json_encode($payment_intent_response['errors']));
}


// Extract the PaymentIntent ID
$payment_intent_id = $payment_intent_response['data']['id'];


// Step 2: Create a PaymentMethod with Card Details
$payment_method_url = 'https://api.paymongo.com/v1/payment_methods';
$payment_method_data = [
    'data' => [
        'attributes' => [
            'type' => 'card',
            'details' => [
                'card_number' => $card_number,
                'exp_month' => (int)$exp_month,
                'exp_year' => (int)$exp_year,
                'cvc' => $cvv,
            ],
            'billing' => [
                'name' => $name,
                'email' => $email,
            ]
        ]
    ]
];


$payment_method_response = api_request($payment_method_url, $payment_method_data, $paymongo_secret_key);


// Check for PaymentMethod creation errors
if (isset($payment_method_response['errors'])) {
    die("PaymentMethod creation failed: " . json_encode($payment_method_response['errors']));
}


// Extract the PaymentMethod ID
$payment_method_id = $payment_method_response['data']['id'];


// Step 3: Attach the PaymentMethod to the PaymentIntent
$attach_payment_url = "https://api.paymongo.com/v1/payment_intents/$payment_intent_id/attach";
$attach_payment_data = [
    'data' => [
        'attributes' => [
            'payment_method' => $payment_method_id
        ]
    ]
];


$final_response = api_request($attach_payment_url, $attach_payment_data, $paymongo_secret_key);


// Check the final status of the payment
if (isset($final_response['data']['attributes']['status']) && $final_response['data']['attributes']['status'] === 'succeeded') {
    echo "Payment successful! Thank you for your purchase.";
} else {
    echo "Payment failed. Reason: ";
    echo isset($final_response['data']['attributes']['last_payment_error']['message'])
        ? $final_response['data']['attributes']['last_payment_error']['message']
        : "Unknown error occurred.";
}


// Helper function for API requests
function api_request($url, $data, $secret_key) {
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Authorization: Basic ' . base64_encode($secret_key . ':')
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    $response = curl_exec($ch);


    if (curl_errno($ch)) {
        die('Request Error: ' . curl_error($ch));
    }


    curl_close($ch);


    return json_decode($response, true);
}
?>
