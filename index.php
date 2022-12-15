<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, PATCH, GET, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

if (!isset($_GET['path']) || isset($path[0])) {
    echo json_encode(['message' => 'Rota não encontrada']);
    exit;
}

$path = explode("/", $_GET['path']);
$api = isset($path[0]) ? $path[0] : '';
$action = isset($path[1]) ? $path[1] : '';
$param = isset($path[2]) ? $path[2] : '';

$method = $_SERVER['REQUEST_METHOD'];

include_once "config/connection.php";
include_once 'api/products.php';
include_once 'api/users.php';
