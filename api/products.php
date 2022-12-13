<?php

if ($api == 'produtos') {
    if ($method == 'GET' && $action == 'list' && $param != '') {
        $db = DB::connect();
        $query = $db->prepare('SELECT p.* FROM produtos p JOIN usuarios u ON p.fk_usuario = u.id WHERE u.id = '.$param);
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['message' => 'Consulta realizada com sucesso', 'dados' => $result]);
            //http_response_code(200);
        } else {
            echo json_encode(['message' => 'Nenhum produto encontrado!']);
            //http_response_code(200);
        }
    } else if ($method == 'GET' && $action == 'total') {
        $db = DB::connect();
        $query = $db->prepare("SELECT SUM(quantidade * valor) as total FROM produtos");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result) {
            echo json_encode(['message' => 'Consulta realizada com sucesso', 'dados' => $result]);
            //http_response_code(200);
        } else {
            echo json_encode(['message' => 'Nenhum produto encontrado!']);
            //http_response_code(200);
        }
    } else if ($method == 'POST' && $action == 'register') {
        $data = json_decode(file_get_contents('php://input'));

        $fk_usuario = $data->fk_usuario;
        $nome = $data->nome;
        $quantidade = $data->quantidade;
        $medida = $data->medida;
        $valor = $data->valor;

        $db = DB::connect();

        $query = $db->prepare("SELECT * FROM produtos WHERE nome = '$nome' and fk_usuario = $fk_usuario");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($resultVerify) {
            echo json_encode(['message' => 'O produto já existe!']);
            //http_response_code(200);
        } else {
            $query = $db->prepare("INSERT INTO produtos (fk_usuario, nome, quantidade, medida, valor) VALUES ($fk_usuario, '$nome', $quantidade, '$medida', $valor)");
            $result = $query->execute();

            if ($result) {
                echo json_encode(['message' => 'Produtos adicionados com sucesso!']);
                //http_response_code(200);
            } else {
                echo json_encode(['message' => 'Erro ao adicionar produtos']);
                //http_response_code(400);
            }
        }
    } else if ($method == 'DELETE' && $action == 'delete' && $param != '') {
        $db = DB::connect();

        $query = $db->prepare("SELECT id FROM produtos WHERE id = $param");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultVerify) {
            echo json_encode(['message' => 'O produto nao existe']);
            //http_response_code(400);
            exit;
        }

        $query = $db->prepare("DELETE FROM produtos WHERE id = $param");
        $result = $query->execute();

        if ($result) {
            echo json_encode(['message' => 'Produto deletado!']);
            //http_response_code(200);
        }
    } else {
        echo json_encode(['message' => 'Caminho não encontrado']);
        //http_response_code(404);
    }
}
