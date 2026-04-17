<?php
require_once "config.php";
require_once "utils.php";
require_once "auth.php";

$input = getJsonInput();

$id = intval($input["id"] ?? 0);
$titulo = trim($input["titulo"] ?? "");
$descricao = trim($input["descricao"] ?? "");
$data_prazo = $input["data_prazo"] ?? null;
$status = $input["status"] ?? "PENDENTE";

if ($id <= 0 || $titulo === "") {
    response(false, "Dados inválidos.");
}

$id_usuario = $_SESSION["user_id"];

// garante que a tarefa pertence ao usuário
$stmt = $pdo->prepare("SELECT id FROM tarefas WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id, $id_usuario]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    response(false, "Tarefa não encontrada ou não pertence ao usuário.");
}

$stmt2 = $pdo->prepare("UPDATE tarefas SET titulo = ?, descricao = ?, data_prazo = ?, status = ? WHERE id = ?");
$stmt2->execute([$titulo, $descricao, $data_prazo, $status, $id]);

response(true, "Tarefa atualizada.");
?>
