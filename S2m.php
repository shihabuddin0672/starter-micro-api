<?php
// API URL
$url = 'http://api.greenweb.com.bd/api.php';

// Your API token
$token = '30811653401693392820d976679e781f540a4ca1fa3ed3631381';

// Check if this is a POST request with JSON data
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_SERVER['CONTENT_TYPE']) && $_SERVER['CONTENT_TYPE'] === 'application/json') {
    // Get the JSON data from the request
    $jsonData = file_get_contents('php://input');

    // Decode the JSON data
    $data = json_decode($jsonData, true);

    // Get the mobile number and message from the JSON data
    $to = $data['to'];
    $message = $data['message'];

    // Data to be sent in the POST request to the SMS API
    $smsData = [
        'token' => $token,
        'to' => $to,
        'message' => $message,
    ];

    // Initialize cURL session
    $ch = curl_init();

    // Set cURL options
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($smsData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

    // Execute the cURL session and get the response
    $response = curl_exec($ch);

    // Check for cURL errors
    if (curl_errno($ch)) {
        echo 'cURL error: ' . curl_error($ch);
    }

    // Close the cURL session
    curl_close($ch);

    // Output the API response
    echo $response;
} else {
    // Handle cases where the request is not a valid JSON POST request
    echo 'Invalid request.';
}
?>
