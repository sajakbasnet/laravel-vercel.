<?php

function handler()
{
    return array(
        "statusCode" => 302,
        "headers" => array(
            "Location" => '/login',
        ),
    );
}
