<?php

// connecting on database..
$db = DB::connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// set my variables to use on my queries
!empty($_GET['prod_id']) ? intval(preg_match('/\d+/', $_GET['prod_id'], $id_prod))                              : $id_prod='';
!empty($_GET['user_id']) ? intval(preg_match('/\d+/', $_GET['user_id'], $id_user))                              : $id_user='';
!empty($_GET['name'])    ? mb_strtolower(preg_match('/[a-zA-Zá-úÁ-Ú]+/', $_GET['name'], $name), 'UTF-8')        : $name='';
!empty($_GET['amount'])  ? intval(preg_match('/\d+/',  $_GET['amount'], $amount))                               : $amount='';
!empty($_GET['metric'])  ? mb_strtolower(preg_match('/[a-zA-Zá-úÁ-Ú]+/', $_GET['metric'], $metric), 'UTF-8')    : $metric='';
!empty($_GET['value'])   ? $value=floatval(str_replace(',', '.', $_GET['value']))  : $value='';

if ($method == 'POST' && $action == 'register') {

    $query = $db->prepare("SELECT ID FROM products WHERE name = '$name[0]' and fk_user = $id_user[0]");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($resultVerify) {
        http_response_code(201);
        echo json_encode(['message' => 'Product already exists.']);
        exit;
    }

    $query = $db->prepare("INSERT INTO products (fk_user, name, amount, metric, value) VALUES ($id_user[0], '$name[0]', $amount[0], '$metric[0]', $value)");
    $result = $query->execute();

    http_response_code(201);
    echo json_encode(['message' => 'Product successfully added.']);
    exit;

} else if ($method == 'PUT' && $action == 'edit') {
    $setters = '';

    if ($name[0])   $setters .= ",name = '$name[0]'";   
    if ($amount[0]) $setters .= ",amount = '$amount[0]'";
    if ($metric[0]) $setters .= ",metric = '$metric[0]'";
    if ($value)  $setters .= ",value = '$value'";

    $setters = ltrim($setters, ',');

    try {
        $query = $db->prepare("UPDATE products SET $setters WHERE ID = $id_prod[0] AND fk_user = $id_user[0]");
        $result = $query->execute();
    } catch(Exception $e) {
        http_response_code(201);
        echo json_encode(['message' => "No changes"]);
        exit;
    }
    
    http_response_code(200);
    echo json_encode(['message' => 'Product was modified!']);
    exit;

} else if ($method == 'GET' && $action == 'list') {

    if (empty($id_user[0])) {
        http_response_code(401);
        echo json_encode(['message' => 'User id is required']);
        exit;
    }

    try {
        $query = $db->prepare("SELECT * FROM products WHERE fk_user = $id_user[0]");

        if (!empty($name[0])) {
            $query = $db->prepare("SELECT * FROM products WHERE fk_user = $id_user[0] AND name LIKE '%$name[0]%'");
        }

        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            http_response_code(201);
            echo json_encode(['message' => 'No product']);
            exit;
        }
    } catch(PDOException $e) {
        http_response_code(400);
        echo json_encode(['message' => $e]);
        exit;
    }
    
    http_response_code(200);
    echo json_encode(['message' => 'Successful query', 'data' => $result]);
    exit;

} else if ($method == 'GET' && $action == 'total') {

    if (empty($id_user[0])) {
        http_response_code(401);
        echo json_encode(['message' => 'User id is required']);
        exit;
    }

    $query = $db->prepare("SELECT SUM(amount * value) as total FROM products WHERE fk_user = $id_user[0]");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(201);
        echo json_encode(['message' => 'No product']);
        exit;
    }
    http_response_code(200);
    echo json_encode(['message' => 'Successful query', 'data' => $result]);
    exit;

} else if ($method == 'DELETE' && $action == 'delete') {

    $query = $db->prepare("SELECT id FROM products WHERE fk_user = $id_user[0] AND ID = $id_prod[0]");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultVerify) {
        http_response_code(201);
        echo json_encode(['message' => 'No product']);
        exit;
    }

    $query = $db->prepare("DELETE FROM products WHERE ID = $id_prod[0] AND fk_user = $id_user[0]");
    $result = $query->execute();

    http_response_code(200);
    echo json_encode(['message' => 'Product deleted']);
    exit;

} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not found']);
    exit;
}
