<?php

//Register all the routes to match with the POST HTTP method.

return [
    
        "auth" => [
            "controller" => 'UserController',
            "method" => 'login'
        ],
        "users" => [
            "controller" => 'UserController',
            "method" => 'create'
        ],
        "quizz" => [
            "controller" => 'QuizzController',
            "method" => "save",
            "auth" => true
        ],
        "ad" => [
            "controller" => 'AdsController',
            "method" => 'create',
            "auth" => true
        ],
        "vehicles" => [
            "controller" => 'VehiclesController',
            "method" => 'create',
            "auth" => true
        ],
        "save-ad-photo" => [
            "controller" => 'AdsController',
            "method" => 'saveFileLink',
            "auth" => true
        ],
        "search-ad" => [
            "controller" => 'AdsController',
            "method" => 'search',
            "auth" => true
        ],
        "wishlist" => [
            "controller" => 'WishlistController',
            "method" => 'save',
            "auth" => true
        ],
        "phone" => [
            "controller" => 'PhoneController',
            "method" => 'save',
            "auth" => true
        ],
        "sale" => [
            "controller" => 'SalesController',
            "method" => 'setAsSold',
            "auth" => true
        ],
        "review" => [
            "controller" => "ReviewsController",
            "method" => 'create',
            "auth" => true
        ],
        "profile-photo" => [
            "controller" => "UserController",
            "method" => 'savePhoto',
            "auth" => true
        ],
        "review-image" => [
            "controller" => "ReviewsController",
            "method" => 'savePhoto',
            "auth" => true
        ],
];