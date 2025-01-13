<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

$url = "https://script.google.com/macros/s/AKfycbwBoEoRS2vX5ZhPXOXQqp6NEi7xeyihM1EKLC-q3eqJtU7L1kgzLOfff5U_AL6CWl1n/exec";
$payload = file_get_contents('php://input');

// Initialize cURL
$ch = curl_init($url);
curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    'Content-Type: application/json',
    'Content-Length: ' . strlen($payload)
]);

// 1) Force cURL to use HTTP/1.1 instead of HTTP/2
curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);

// 2) Follow redirects, if any
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

// 3) Temporarily disable SSL verification (for testing only)
//    Ideally, install proper CA certs on your server for production
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);

// Execute the request
$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
$curlError = curl_error($ch);
curl_close($ch);

// Return response or error
if ($response !== false && $httpCode >= 200 && $httpCode < 300) {
    // If it's an HTTP 2xx success code, echo the response
    echo $response; 
} else {
    // For debugging, return the cURL error + HTTP code
    echo "Error: " . ($curlError ?: $response) . " (HTTP code: $httpCode)";
}
?>
