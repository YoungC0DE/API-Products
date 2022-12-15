<?php

if ($api == 'usuarios') {
    if ($method == 'POST' && $action == 'login') {
        $data = json_decode(file_get_contents('php://input'));

        $email = $data->email;
        $senha = $data->senha;

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            //http_response_code(400);
            echo json_encode(['message' => 'Usuário ou senha incorretos!', 'code' => 400]);
            exit;
        }

        $token = $db->prepare("SELECT id, nome, acesso FROM usuarios WHERE email = '$email' AND senha = '$senha'");
        $token->execute();
        $result2 = $token->fetchAll(PDO::FETCH_ASSOC);

        //http_response_code(200);
        echo json_encode(['message' => 'Logado com sucesso!', 'dados' => $result2, 'code' => 200]);
    } else if ($method == 'POST' && $action == 'register') {
        $data = json_decode(file_get_contents('php://input'));

        $nome = trim($data->nome);
        $email = trim($data->email);
        $senha = trim($data->senha);

        if ($nome == '' || $email == '' || $senha == '') {
            //http_response_code(401);
            echo json_encode(['message' => 'Informe todas as credenciais', 'code' => 401]);
            exit;
        }

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM usuarios WHERE email = '$email'");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($resultVerify) {
            //http_response_code(401);
            echo json_encode(['message' => 'O login já existe!', 'code' => 401]);
            exit;
        }

        $query = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email', '$senha')");
        $result = $query->execute();

        if (!$result) {
            //http_response_code(400);
            echo json_encode(['message' => 'Erro ao criar login!', 'code' => 400]);
            exit;
        }
        //http_response_code(200);
        echo json_encode(['message' => 'Login criado com sucesso!', 'code' => 200]);
    } else if ($method == 'GET' && $action == 'list') {
        $db = DB::connect();

        $query = $db->prepare("SELECT id, nome, email, acesso FROM usuarios");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            //http_response_code(404);
            echo json_encode(['message' => 'Nenhum usuário encontrado!', 'code' => 404]);
            exit;
        }
        //http_response_code(200);
        echo json_encode(['message' => 'Consulta realizada com sucesso', 'dados' => $result, 'code' => 200]);
    } else if ($method == 'DELETE' && $action == 'delete') {
        $data = json_decode(file_get_contents('php://input'));

        $email = $data->email;
        $senha = $data->senha;

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM usuarios WHERE email = '$email' and senha = '$senha'");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultVerify) {
            //http_response_code(404);
            echo json_encode(['message' => 'Usuario não existe!', 'code' => 401]);
            exit;
        }
        $query = $db->prepare("DELETE FROM usuarios WHERE email = '$email' and senha = '$senha'");
        $result = $query->execute();

        if (!$result) {
            echo json_encode(['message' => 'Erro ao deletar conta!', 'code' => 400]);
            //http_response_code(400);
            exit;
        }

        echo json_encode(['message' => 'Conta deletada com sucesso!', 'code' => 200]);
        //http_response_code(200);
    } else {
        echo json_encode(['message' => 'Caminho não encontrado', 'code' => 404]);
        //http_response_code(404);
    }
}
