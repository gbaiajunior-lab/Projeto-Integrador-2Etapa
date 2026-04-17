<?php
require_once "config.php";
require_once "utils.php";
require_once "auth.php";

$input = getJsonInput();

$titulo = trim($input["titulo"] ?? "");
$descricao = trim($input["descricao"] ?? "");
$data_prazo = $input["data_prazo"] ?? null;

if ($titulo === "") {
    response(false, "Título é obrigatório.");
}

$id_usuario = $_SESSION["user_id"];

$stmt = $pdo->prepare("INSERT INTO tarefas (titulo, descricao, data_prazo, id_usuario) VALUES (?, ?, ?, ?)");
$stmt->execute([$titulo, $descricao, $data_prazo, $id_usuario]);

response(true, "Tarefa criada com sucesso.");
?>
