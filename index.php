<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");
header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Cache-Control, Pragma, Authorization, Accept, Accept-Encoding");
header("Content-type: application/json");

date_default_timezone_set("America/Sao_Paulo");

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);

    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_METHOD']))
        header("Access-Control-Allow-Methods: POST, PUT, GET, DELETE");
    if (isset($_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']))
        header("Access-Control-Allow-Headers: {$_SERVER['HTTP_ACCESS_CONTROL_REQUEST_HEADERS']}");
    // header("Access-Control-Allow-Headers: X-Requested-With, Content-Type, Origin, Authorization, Accept, Client-Security-Token, Accept-Encoding");
    exit;
}

if (empty($_GET['path'])) {
    http_response_code(404);
    echo json_encode(['message' => 'Please, specify the full route. See the readme: https://github.com/YoungC0DE/API-Produtos']);
    exit;
}
// domain/api/action
$path = explode("/", $_GET['path']);

// POST, GET, DELETE, PUT
$method = $_SERVER['REQUEST_METHOD'];

// SERVER
try {
    $api = isset($path[1]) ? $path[1] : '';
    $action = isset($path[2]) ? $path[2] : '';
} catch(Exception $e) {
    http_response_code(204);
    echo json_encode(['message' => 'Please, specify the full route. See the readme: https://github.com/YoungC0DE/API-Produtos']);
    exit;
}

// LOCAL
// $api = isset($path[0]) ? $path[0] : '';
// $action = isset($path[1]) ? $path[1] : '';;

include_once "config/connection.php";

if ($api === 'products') include_once "api/products.php";
if ($api === 'users')    include_once "api/users.php";
else {
    http_response_code(404);
    echo json_encode(['message' => 'Not found']);
    exit;
}
