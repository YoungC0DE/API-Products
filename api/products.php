<?php

if ($api == 'produtos') {
    if ($method == 'GET' && $action == 'list') {
        $db = DB::connect();
        $query = $db->prepare('SELECT * FROM produtos');
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => $result]);
        } else {
            echo json_encode(['dados' => 'Nenhum produto encontrado!']);
        }

    } else if ($method == 'GET' && $action == 'total') {
        $db = DB::connect();
        $query = $db->prepare("SELECT SUM(quantidade * valor) as total FROM produtos");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['dados' => $result]);
        } else {
            echo json_encode(['dados' => 'Nenhum produto encontrado!']);
        }

    } else if ($method == 'POST' && $action == 'register') {
        $data = json_decode(file_get_contents('php://input'));

        $fk_usuario = $data -> fk_usuario;
        $nome = $data -> nome;
        $quantidade = $data -> quantidade;
        $medida = $data -> medida;
        $valor = $data -> valor;

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM produtos WHERE nome = '$nome' and fk_usuario = $fk_usuario");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($resultVerify) {
            echo json_encode(['dados' => 'O produto já existe!']);
        } else {
            $query = $db->prepare("INSERT INTO produtos (fk_usuario, nome, quantidade, medida, valor) VALUES ($fk_usuario, '$nome', $quantidade, '$medida', $valor)");
            $result = $query->execute();

            if ($result) {
                echo json_encode(['dados' => 'Produtos adicionados com sucesso!']);
            } else {
                echo json_encode(['dados' => 'Erro ao adicionar produtos']);
            }
        }

    } else if ($method == 'DELETE' && $action == 'delete' && $param != '') {
        $db = DB::connect();
        $query = $db->prepare("DELETE FROM produtos WHERE id = $param");
        $result = $query->execute();

        if ($result) {
            echo json_encode(['dados' => 'Produto deletado!']);
        } else {
            echo json_encode(['dados' => 'Erro ao deletar o produtos']);
        }
    } else {
        echo json_encode(['ERRO' => 'Caminho não encontrado']);
    }
}
