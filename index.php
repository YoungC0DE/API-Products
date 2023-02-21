<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, PATCH, GET, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

ini_set('display_errors', 1);
ini_set('display_startup_erros', 1);
error_reporting(E_ALL);

if (!isset($_GET['path'])) {
    http_response_code(404);
    echo json_encode(['message' => 'Rota não encontrada']);
    
}
// domain/api/action/{param}
$path = explode("/", $_GET['path']);

// POST, GET, DELETE, PUT
$method = $_SERVER['REQUEST_METHOD'];

// SERVER
$api = isset($path[1]) ? $path[1] : '';
$action = isset($path[2]) ? $path[2] : '';
$param = isset($path[3]) ? $path[3] : '';

// LOCAL
// $api = isset($path[0]) ? $path[0] : '';
// $action = isset($path[1]) ? $path[1] : '';
// $param = isset($path[2]) ? $path[2] : '';

include_once "config/connection.php";

if ($api === 'products') include_once "api/products.php";
if ($api === 'user') include_once "api/users.php";
else {
    http_response_code(404);
    echo json_encode(['message' => 'Rota não encontrada']);
    exit;
}
