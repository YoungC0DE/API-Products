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
    echo json_encode(['message' => 'Rota não encontrada', 'code' => 404]);
    exit;
}

$path = explode("/", $_GET['path']);

$api = isset($path[1]) ? $path[1] : '';
$action = isset($path[2]) ? $path[2] : '';
$param = isset($path[3]) ? $path[3] : '';

$method = $_SERVER['REQUEST_METHOD'];

include_once "config/connection.php";
include_once "api/products.php";
include_once "api/users.php";
