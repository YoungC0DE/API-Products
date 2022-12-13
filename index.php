<?php
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: POST, PUT, PATCH, GET, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: *');
header('Content-type: application/json');

date_default_timezone_set("America/Sao_Paulo");

if (isset($_GET['path'])) {
    $path = explode("/", $_GET['path']);
} else {
    echo json_encode(['message' => 'Caminho não encontrado']);
    exit;
}

if (isset($path[0])) {
    $api = $path[0];
} else {
    echo json_encode(['message' => 'Caminho não encontrado']);
    exit;
}
if (isset($path[1])) {
    $action = $path[1];
} else {
    $action = '';
}
if (isset($path[2])) {
    $param = $path[2];
} else {
    $param = '';
}

$method = $_SERVER['REQUEST_METHOD'];

include_once "config/connection.php";
include_once 'api/products.php';
include_once 'api/users.php';
