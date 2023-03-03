<?php

// connecting on database..
$db = DB::connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// get all request data
$data = json_decode(file_get_contents('php://input'));

// defines what i need to replace
$remov = array("'", ".", "\\", "-", "(", ")");

// set my variables to use on my queries
$id_prod = !empty($data->id_prod) ? intval(trim($data->id_prod)) : '';
$id_user = !empty($data->id_user) ? intval(trim($data->id_user)) : '';
$name    = !empty($data->name)    ? strtolower(trim(str_replace($remov, "", $data->name))) : '';
$amount  = !empty($data->amount)  ? intval(trim($data->amount)) : '';
$metric  = !empty($data->metric)  ? strtolower(trim(str_replace($remov, "", $data->metric))) : '';
$value   = !empty($data->value)   ? intval(trim(str_replace($remov, "", $data->value))) : '';

if ($method == 'POST' && $action == 'register') {

    $query = $db->prepare("SELECT id FROM products WHERE name = '$name' and fk_user = $id_user");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($resultVerify) {
        http_response_code(400);
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
        http_response_code(400);
        echo json_encode(['message' => "No changes"]);
        exit;
    }
    
    http_response_code(201);
    echo json_encode(['message' => 'Product was modified!']);
    exit;

} else if ($method == 'GET' && $action == 'list') {

    try {
        $query = $db->prepare("SELECT * FROM products WHERE fk_user = $id_user");

        // if (!empty($name)) {
        //     $query = $db->prepare("SELECT * FROM products WHERE fk_user = $id_user AND name ILIKE '%".$name."%'");
        // }

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

    $query = $db->prepare("SELECT SUM(amount * value) as total FROM products WHERE fk_user = $id_user");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(400);
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
        http_response_code(400);
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
