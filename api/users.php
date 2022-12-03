<?php

if ($api == 'usuarios') {
    if ($method == 'POST' && $action == 'login') {
        $nome = array_values($_POST)[0];
        $senha = array_values($_POST)[1];

        $db = DB::connect();
        $query = $db->prepare("SELECT * FROM usuarios WHERE email = '$nome' AND senha = '$senha'");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => 'Logado com sucesso!']);
        } else {
            echo json_encode(['dados' => 'Usuário ou senha incorretos!']);
        }
    }
    else { echo json_encode(['ERRO' => 'Caminho não encontrado']); }
}
