<?php

if ($api == 'usuarios') {
    if ($method == 'POST' && $action == 'login') {
        $email = array_values($_POST)[0];
        $senha = array_values($_POST)[1];

        $db = DB::connect();
        $query = $db->prepare("SELECT * FROM usuarios WHERE email = '$email' AND senha = '$senha'");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => 'Logado com sucesso!']);
        } else {
            echo json_encode(['dados' => 'Usuário ou senha incorretos!']);
        }
    }
    else if ($method == 'POST' && $action == 'register') {
        $nome = array_values($_POST)[0];
        $email = array_values($_POST)[1];
        $senha = array_values($_POST)[2];

        $db = DB::connect();
        $query = $db->prepare("INSERT INTO usuarios (nome, email, senha) VALUES ('$nome', '$email' '$senha')";
        $result = $query->execute();

        if ($result) {
            echo json_encode(['dados' => 'Logado com sucesso!']);
        } else {
            echo json_encode(['dados' => 'Usuário ou senha incorretos!']);
        }
    }
    else { echo json_encode(['ERRO' => 'Caminho não encontrado']); }
}
