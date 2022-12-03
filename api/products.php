<?php

if ($api == 'produtos') {
    if ($method == 'GET' && $action == 'listar') {
        $db = DB::connect();
        $query = $db->prepare('SELECT * FROM produtos');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => $result]);
        } else {
            echo json_encode(['dados' => 'Nenhum produto encontrado!']);
        }
    }
    else if ($method == 'GET' && $action == 'total') {
        $db = DB::connect();
        $query = $db->prepare("SELECT SUM(valor) as total FROM produtos");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => $result]);
        } else {
            echo json_encode(['dados' => 'Nenhum produto encontrado!']);
        }
    }
    else if ($method == 'POST' && $action == 'criar') {
        $nome = array_values($_POST)[0];
        $quantidade = intval(array_values($_POST)[1]);
        $medida = array_values($_POST)[2];
        $valor = floatval(array_values($_POST)[3]);

        $db = DB::connect();
        $query = $db->prepare("INSERT INTO produtos (nome, quantidade, medida, valor) VALUES ('$nome', $quantidade, '$medida', $valor)");
        $result = $query->execute();

        if ($result) {
            echo json_encode(['dados' => 'Produtos adicionados com sucesso!']);
        } else {
            echo json_encode(['dados' => 'Erro ao adicionar produtos']);
        }
    }
    else if ($method == 'DELETE' && $action == 'deletar' && $param != '') {
        $db = DB::connect();
        $query = $db->prepare("DELETE FROM produtos WHERE id = $param");
        $result = $query->execute();

        if ($result) {
            echo json_encode(['dados' => 'Produto deletado!']);
        } else {
            echo json_encode(['dados' => 'Erro ao deletar o produtos']);
        }
    }
    else { echo json_encode(['ERRO' => 'Caminho não encontrado']); }
}
