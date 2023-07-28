<?php

function handler($event, $context)
{

    $redirectUrl = "/login";
    $response = array(
        "statusCode" => 302,
        "headers" => array(
            "Location" => $redirectUrl,
        ),
    );
    return $response;
}
