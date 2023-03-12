<?php

// connecting on database..
$db = DB::connect();
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// defines what i need to replace
$remov = array("'", "\\", "-", "(", ")");

// set my variables to use on my queries
$id_user  = !empty($_GET['user_id'])  ? intval(trim($_GET['user_id'])) : '';
$name     = !empty($_GET['name'])     ? trim(str_replace($remov, "", $_GET['name'])) : '';
$email    = !empty($_GET['email'])    ? trim(strtolower(str_replace($remov, "", $_GET['email']))) : '';
$password = !empty($_GET['password']) ? base64_encode(trim(str_replace($remov, "", $_GET['password']))) :  '';
$avatar   = !empty($_GET['avatar'])   ? $_GET['avatar'] : '';

if ($method == 'POST' && $action == 'login') {

    $query = $db->prepare("SELECT * FROM users WHERE email = '$email' AND password = '$password'");
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(401);
        echo json_encode(['message' => 'Email or password incorrect!']);
        exit;
    }

    http_response_code(200);
    echo json_encode(['message' => 'successfully logged in', 'data' => $result]);
    exit;

} else if ($method == 'POST' && $action == 'register') {

    if ($name == '' || $email == '' || $password == '') {
        http_response_code(403);
        echo json_encode(['message' => 'Provide all credentials']);
        exit;
    }

    $query = $db->prepare("SELECT id FROM users WHERE email = '$email'");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if ($resultVerify) {
        http_response_code(401);
        echo json_encode(['message' => 'User already exists']);
        exit;
    }

    $query = $db->prepare("INSERT INTO users (name, email, password) VALUES ('$name', '$email', '$password')");
    $result = $query->execute();

    http_response_code(200);
    echo json_encode(['message' => 'User was created!']);
    exit;

} else if ($method == 'PUT' && $action == 'edit') {

    if (empty($id_user)) {
        http_response_code(401);
        echo json_encode(['message' => 'User id is required']);
        exit;
    }
    
    $setters = '';

    if ($name)     $setters .= ",name = '$name'";  
    if ($email)    $setters .= ",email = '$email'"; 
    if ($password) $setters .= ",password = '$password'";
    if ($avatar)   $setters .= ",avatar = '$avatar'";

    $setters = ltrim($setters, ',');

    try {
        $query = $db->prepare("UPDATE users SET $setters WHERE ID = $id_user");
        $result = $query->execute();
    } catch(Exception $e) {
        http_response_code(403);
        echo json_encode(['message' => "$e"]);
        exit;
    }
    
    http_response_code(200);
    echo json_encode(['message' => 'User was modified!']);
    exit;

} else if ($method == 'GET' && $action == 'list') {

    $stringQuery = "SELECT * FROM users";

    if (!empty($id_user)) $stringQuery = "SELECT * FROM users WHERE ID = $id_user";

    $query = $db->prepare($stringQuery);
    $query->execute();
    $result = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$result) {
        http_response_code(201);
        echo json_encode(['message' => 'No users found']);
        exit;
    }

    http_response_code(200);
    echo json_encode(['message' => 'Sucessfully', 'data' => $result]);
    exit;

} else if ($method == 'DELETE' && $action == 'delete') {

    if (empty($id_user)) {
        http_response_code(401);
        echo json_encode(['message' => 'User id is required']);
        exit;
    }

    $query = $db->prepare("SELECT id FROM users WHERE email = '$email' AND password = '$password'");
    $query->execute();
    $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

    if (!$resultVerify) {
        http_response_code(401);
        echo json_encode(['message' => 'User not exists']);
        exit;
    }

    $query = $db->prepare("DELETE FROM users WHERE email = '$email' AND password = '$password'");
    $result = $query->execute();

    http_response_code(200);
    echo json_encode(['message' => 'Account was deleted']);
    exit;

} else {
    http_response_code(404);
    echo json_encode(['message' => 'Not found']);
    exit;
}
