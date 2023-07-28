<?php
// api/index.php - Serverless Function

// Handler function that receives the event and context parameters
function handler($event, $context) {
    // Set the redirect URL to the login page
    $redirectUrl = "/login";

    // Set the response headers for the redirect
    $response = array(
        "statusCode" => 302, // 302 Found - Redirect
        "headers" => array(
            "Location" => $redirectUrl,
        ),
    );
    return $response;
}

// Invoke the handler function with the provided event and context
$event = json_decode($_ENV['VERCEL_EVENT'], true);
$context = json_decode($_ENV['VERCEL_CONTEXT'], true);
$result = handler($event, $context);

// Output the response
http_response_code($result['statusCode']);
foreach ($result['headers'] as $key => $value) {
    header("$key: $value");
}
