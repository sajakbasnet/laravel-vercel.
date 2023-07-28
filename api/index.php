<?php

function handler($event, $context) {
    // Your serverless function logic goes here
    $response = array(
        "statusCode" => 200,
        "headers" => array(
            "Content-Type" => "application/json",
        ),
        "body" => json_encode(array("message" => "Hello, this is the API endpoint.")),
    );
    return $response;
}
