<?php

require_once 'autoload.php';
require_once 'App/Config/config.php';
require_once 'App/Routes/routes.php';

use App\Lib\Auth\JWT;
use App\Lib\Auth\Auth;
use App\Lib\Response\Response;

$httpMethod = $_SERVER['REQUEST_METHOD'];
if (array_key_exists($httpMethod, $routes) == false) {
    die("Metodo HTTP incorreto!");
}

$availableRoutes = $routes[$httpMethod];
$fullUrl = array_key_exists('url', $_GET) ? $_GET['url'] : '';
$url = explode('/', $fullUrl)[0];

if($url == "getToken"){
    echo json_encode([
        "token" => JWT::encode(1,0)
    ]);
    die;
}

if (array_key_exists($url, $availableRoutes) == false) {
    Response::notFound();
}

try {
    $request = $availableRoutes[$url];
    if(array_key_exists('auth', $request)){
        new Auth();
    }

    $controller = "App\\Controller\\{$request['controller']}";
    $method = $request['method'];

    (new $controller)->$method();
} catch (Exception $e) {
    Response::internalServerError($e->getMessage());
}

function dd($var, $kill = true)
{
    echo '<pre>';
    var_dump($var);
    echo '</pre>';
    if ($kill == false) {
        return;
    }
    die;
}
