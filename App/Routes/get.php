<?php

//Register all the routes to match with the GET HTTP method.

return [
    /*"login" => [
        "controller" => 'UserController',
        "method" => 'login'
    ]*/
    "quizz" => [
        "controller" => 'QuizzController',
        "method" => 'getCars',
        "auth" => true
    ],
    "check-quizz" => [
        "controller" => 'QuizzController',
        "method" => 'checkQuizz',
        "auth" => true
    ],
    "ads" => [
        "controller" => 'AdsController',
        "method" => 'getAll',
        "auth" => true
    ],
    "ad-details" => [
        "controller" => 'AdsController',
        "method" => 'details',
        "auth" => true
    ],
    "order-ads-by-views" => [
        "controller" => 'AdsController',
        "method" => 'getByViews',
        "auth" => true
    ],
    "user-ads" => [
        "controller" => 'AdsController',
        "method" => 'getUserAds',
        "auth" => true
    ],
    "brands" => [
        "controller" => 'BrandsController',
        "method" => 'getAll'
    ],
    "get-by-price" => [
        "controller" => 'AdsController',
        "method" => 'getByPrice',
        "auth" => true
    ],
    "wishlist" => [
        "controller" => 'WishlistController',
        "method" => 'getById',
        "auth" => true
    ],
    "phone" => [
        "controller" => 'PhoneController',
        "method" => 'getByUser',
        "auth" => true
    ],
    "sale" => [
        "controller" => 'SalesController',
        "method" => 'get',
        "auth" => true
    ],
    "review" => [
        "controller" => "ReviewsController",
        "method" => 'getById',
        "auth" => true
    ],
    "get-all-reviews" => [
        "controller" => "ReviewsController",
        "method" => 'getAll',
        "auth" => true
    ],
    "get-address-by-id" => [
        "controller" => 'AddressController',
        "method" => "getById",
        "auth" => true
    ],
    "user" => [
        "controller" => "UserController",
        "method" => "getById",
        "auth" => true
    ],
    "user-image" => [
        "controller" => "UserController",
        "method" => "getUserImage",
        "auth" => true
    ],
    "get-by-user-id" => [
        "controller" => "AddressController",
        "method" => "getByUser",
        "auth" => true
    ]
];
