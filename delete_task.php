<?php
require_once "config.php";
require_once "utils.php";
require_once "auth.php";

$input = getJsonInput();
$id = intval($input["id"] ?? 0);

if ($id <= 0) {
    response(false, "ID inválido.");
}

$id_usuario = $_SESSION["user_id"];

$stmt = $pdo->prepare("DELETE FROM tarefas WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id, $id_usuario]);

if ($stmt->rowCount() === 0) {
    response(false, "Tarefa não encontrada ou não pertence ao usuário.");
}

response(true, "Tarefa excluída.");
?>
