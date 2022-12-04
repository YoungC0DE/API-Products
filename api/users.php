<?php

if ($api == 'usuarios') {
    if ($method == 'POST' && $action == 'login') {
        $data = json_decode(file_get_contents('php://input'));

        $email = $data -> email;
        $senha = $data -> senha;

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => 'Logado com sucesso!']);
        } else {
            echo json_encode(['dados' => 'Usuário ou senha incorretos!']);
        }
    } else if ($method == 'POST' && $action == 'register') {
        $data = json_decode(file_get_contents('php://input'));

        $nome = $data -> nome;
        $email = $data -> email;
        $senha = $data -> senha;

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM usuarios WHERE email = $email");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($resultVerify) {
            echo json_encode(['dados' => 'O login já existe!']);
        } else {
            $query = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email' '$senha')");
            $result = $query->execute();

            if ($result) {
                echo json_encode(['dados' => 'Login criado com sucesso!']);
            } else {
                echo json_encode(['dados' => 'Erro ao criar login!']);
            }
        }
    } else {
        echo json_encode(['ERRO' => 'Caminho não encontrado']);
    }
}
