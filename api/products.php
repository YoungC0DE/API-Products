<?php
$db = DB::connect();

if ($api == 'produtos') {
    if ($method == 'GET' && $action == 'list' && $param != '') {
        $query = $db->prepare("SELECT p.* FROM produtos p JOIN usuarios u ON p.fk_usuario = u.id WHERE u.id = $param");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$result) {
            echo json_encode(['message' => 'Nenhum produto encontrado!', 'code' => 404]);
            //http_response_code(404);
            exit;
        }
        //http_response_code(200);
        echo json_encode(['message' => 'Consulta realizada com sucesso', 'dados' => $result, 'code' => 200]);
    } else if ($method == 'GET' && $action == 'total' && $param != '') {

        $query = $db->prepare("SELECT id FROM usuarios where id = $param");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        $query = $db->prepare("SELECT SUM(quantidade * valor) as total FROM produtos where fk_usuario = $param");
        $query->execute();
        $result = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($result[0]['total'] == null) {
            echo json_encode(['message' => 'Nenhum produto encontrado!', 'code' => 404]);
            //http_response_code(404);
            exit;
        }
        echo json_encode(['message' => 'Consulta realizada com sucesso', 'dados' => $result, 'code' => 200]);
        //http_response_code(200);

    } else if ($method == 'POST' && $action == 'register' && $param != '') {
        $data = json_decode(file_get_contents('php://input'));

        $remov = array("'", ".", "\\", "-", "(", ")");

        $nome = strtolower(trim(str_replace($remov, "", $data->nome)));
        $quantidade = $data->quantidade;
        $medida = strtolower(trim(str_replace($remov, "", $data->medida)));
        $valor = intval(trim(str_replace($remov, "", $data->valor)));


        $query = $db->prepare("SELECT * FROM produtos WHERE nome = '$nome' and fk_usuario = $param");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if ($resultVerify) {
            echo json_encode(['message' => 'O produto já existe!', 'code' => 401]);
            //http_response_code(200);
            exit;
        }
        $query = $db->prepare("INSERT INTO produtos (fk_usuario, nome, quantidade, medida, valor) VALUES ($param, '$nome', $quantidade, '$medida', $valor)");
        $result = $query->execute();

        if (!$result) {
            echo json_encode(['message' => 'Erro ao adicionar produtos', 'code' => 400]);
            //http_response_code(400);
            exit;
        }

        echo json_encode(['message' => 'Produtos adicionados com sucesso!', 'code' => 200]);
        //http_response_code(200);
    } else if ($method == 'DELETE' && $action == 'delete' && $param != '') {
        $data = json_decode(file_get_contents('php://input'));

        $id = $data->id_user;

        $query = $db->prepare("SELECT id FROM produtos WHERE id = $param AND fk_usuario = $id");
        $query->execute();
        $resultVerify = $query->fetchAll(PDO::FETCH_ASSOC);

        if (!$resultVerify) {
            echo json_encode(['message' => 'O produto não existe', 'code' => 400]);
            //http_response_code(400);
            exit;
        }

        $query = $db->prepare("DELETE FROM produtos WHERE id = $param AND fk_usuario = $id");
        $result = $query->execute();

        if (!$result) {
            echo json_encode(['message' => 'Erro ao deletar o produto', 'code' => 400]);
            //http_response_code(400);
            exit;
        }

        echo json_encode(['message' => 'Produto deletado!', 'code' => 200]);
        //http_response_code(400);
    } else {
        echo json_encode(['message' => 'Caminho não encontrado', 'code' => 404]);
        //http_response_code(404);
    }
}
