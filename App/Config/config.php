<?php
declare(strict_types=1);
require_once 'httpStatus.php';
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS, PUT, DELETE");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

use App\Lib\Environment\EnvData;

define('DATABASE', EnvData::get('DB_NAME'));
define('DB_HOST', EnvData::get('DB_HOST'));
define('DB_USER', EnvData::get("DB_USER"));
define('DB_PASSWORD', EnvData::get('DB_PASSWORD'));

define('CERT_PATH', EnvData::get('CERT_PATH'));
define('JWT_SECRET', EnvData::get('JWT_SECRET'));
