<?php

//Register all the routes to match with the PUT HTTP method.

return [
    /*
        "login" => [
            "controller" => 'exampleController',
            "method" => 'exampleMethod'
        ]
    */
    "quizz" => [
        "controller" => 'quizzController',
        "method" => 'update',
        "auth" => true
    ],
    "views" => [
        "controller" => 'AdsController',
        "method" => "increaseViews",
        "auth" => true
    ],
    "user" => [
        "controller" => 'UsersController',
        "method" => "update",
        "auth" => true
    ],
    "address" => [
        "controller" => 'AddressController',
        "method" => "update",
        "auth" => true
    ],
    "review" => [
        "controller" => "ReviewsController",
        "method" => 'update',
        "auth" => true
    ],
    "update-user" => [
        "controller" => "UserController",
        "method" => "update",
        "auth" => true
    ],
    "profile-photo" => [
        "controller" => "UserController",
        "method" => 'updatePhoto',
        "auth" => true
    ],
];
