<?php

// connecting on database..
$db = DB::connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// defines what i need to replace
$remov = array("'", ".", "\\", "-", "(", ")");

// set my variables to use on my queries
$id_prod = !empty($_GET['prod_id']) ? intval(trim($_GET['prod_id'])) : '';
$id_user = !empty($_GET['user_id']) ? intval(trim($_GET['user_id'])) : '';
$name    = !empty($_GET['name'])    ? strtolower(trim(str_replace($remov, "", $_GET['name']))) : '';
$amount  = !empty($_GET['amount'])  ? intval(trim($_GET['amount'])) : '';
$metric  = !empty($_GET['metric'])  ? strtolower(trim(str_replace($remov, "", $_GET['metric']))) : '';
$value   = !empty($_GET['value'])   ? intval(trim(str_replace($remov, "", $_GET['value']))) : '';

if ($method == 'POST' && $action == 'register') {

    $query = $db->prepare("SELECT ID FROM products WHERE name = '$name' and fk_user = $id_user");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($resultVerify) {
        http_response_code(201);
        echo json_encode(['message' => 'Product already exists.']);
        exit;
    }

    $query = $db->prepare("INSERT INTO products (fk_user, name, amount, metric, value) VALUES ($id_user, '$name', $amount, '$metric', $value)");
    $result = $query->execute();

    http_response_code(201);
    echo json_encode(['message' => 'Product successfully added.']);
    exit;

} else if ($method == 'PUT' && $action == 'edit') {
    $setters = '';

    if ($name)   $setters .= ",name = '$name'";   
    if ($amount) $setters .= ",amount = '$amount'";
    if ($metric) $setters .= ",metric = '$metric'";
    if ($value)  $setters .= ",value = '$value'";

    $setters = ltrim($setters, ',');

    try {
        $query = $db->prepare("UPDATE products SET $setters WHERE ID = $id_prod AND fk_user = $id_user");
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

    if (empty($id_user)) {
        http_response_code(401);
        echo json_encode(['message' => 'User id is required']);
        exit;
    }

    try {
        $query = $db->prepare("SELECT * FROM products WHERE fk_user = $id_user");

        if (!empty($name)) {
            $query = $db->prepare("SELECT * FROM products WHERE fk_user = $id_user AND name ILIKE '%$name%'");
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

    if (empty($id_user)) {
        http_response_code(401);
        echo json_encode(['message' => 'User id is required']);
        exit;
    }

    $query = $db->prepare("SELECT SUM(amount * value) as total FROM products WHERE fk_user = $id_user");
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

    $query = $db->prepare("SELECT id FROM products WHERE fk_user = $id_user AND ID = $id_prod");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultVerify) {
        http_response_code(201);
        echo json_encode(['message' => 'No product']);
        exit;
    }

    $query = $db->prepare("DELETE FROM products WHERE ID = $id_prod AND fk_user = $id_user");
    $result = $query->execute();

    http_response_code(200);
    echo json_encode(['message' => 'Product deleted']);
    exit;

} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not found']);
    exit;
}
