<?php

//Register all the routes to match with the DELETE HTTP method.

return [
    /*
        "login" => [
            "controller" => 'exampleController',
            "method" => 'exampleMethod'
        ]
    */
    "wishlist" => [
        "controller" => 'wishlistController',
        "method" => "delete",
        "auth" => true
    ], 
    "phone" => [
        "controller" => 'PhoneController',
        "method" => 'delete',
        "auth" => true
    ],
    "review" => [
        "controller" => "ReviewsController",
        "method" => 'delete',
        "auth" => true
    ],
];