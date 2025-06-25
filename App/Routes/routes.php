<?php

$routes = [
    "GET" => require_once 'get.php',
    "POST" => require_once 'post.php',
    "PUT" => require_once 'put.php',
    "PATCH" => require_once 'patch.php',
    "DELETE" => require_once 'delete.php',
];