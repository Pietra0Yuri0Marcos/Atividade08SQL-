<?php

header("Content-Type: application/json");

require "conexao.php";

$metodo = $_SERVER["REQUEST_METHOD"];

if($metodo == "POST"){
    $json = file_get_contents("php://input");

    $dados = json_decode($json,true);

    $prioridades = ["baixa", "media", "alta"];
    $statusPermitidos = ["aberto", "em andamento", "concluido"];

    if(
        $dados["prioridade"] != "baixa" &&
        $dados["prioridade"] != "media" &&
        $dados["prioridade"] != "alta"
    ){
        echo json_encode(["erro" => "Opção inválida"]);
    }

    else if(
        $dados["status"] != "aberto" &&
        $dados["status"] != "em andamento" &&
        $dados["status"] != "concluido"
    ){
        echo json_encode(["erro" => "Opção inválida"]);
    }

    else{

    $sql = "INSERT INTO chamados (equipamento,setor,descricao,prioridade,status) VALUES (?,?,?,?,?)";

    $comando = $pdo -> prepare($sql);

    $comando -> execute([
        $dados["equipamento"],
        $dados["setor"],
        $dados["descricao"],
        $dados["prioridade"],
        $dados["status"]
    ]);

    echo json_encode(["Mensagem"=>"Chamado cadastrado!"]);
        };
    };

if ($metodo == "GET"){

    $sql = "SELECT * FROM chamados";

    $comando = $pdo -> query($sql);

    $chamados = $comando -> fetchAll(PDO::FETCH_ASSOC);

    echo json_encode($chamados);

};

if ($metodo == "PUT"){

    $json = file_get_contents("php://input");
    
    $dados = json_decode($json,true);

    if(
        $dados["prioridade"] != "baixa" &&
        $dados["prioridade"] != "media" &&
        $dados["prioridade"] != "alta"
    ){
        echo json_encode([
            "erro" => "Opção inválida"
        ]);
    }
    else if(
        $dados["status"] != "aberto" &&
        $dados["status"] != "em andamento" &&
        $dados["status"] != "concluido"
    ){
        echo json_encode([
            "erro" => "Opção inválida"
        ]);
    }

    else{

    $sql = "UPDATE chamados SET equipamento=?, setor=?, descricao=?, prioridade=?, status=? WHERE id = ?";

    $comando = $pdo -> prepare($sql);

    $comando -> execute([
        $dados["equipamento"],
        $dados["setor"],
        $dados["descricao"],
        $dados["prioridade"],
        $dados["status"],
        $dados["id"]
    ]);

    echo json_encode(["Mensagem"=>"Chamado atualizados!"]);
        };
    };

if ($metodo == "DELETE"){

    $json = file_get_contents("php://input");

    $dados = json_decode($json,true);

    $sql = "DELETE FROM chamados WHERE id=?";

    $comando = $pdo -> prepare($sql);

    $comando -> execute([
        $dados["id"]
    ]);

    echo json_encode(["Mensagem"=>"Chamado excluido!"]);
};

?>