<?php
require_once "config.php";
require_once "utils.php";
require_once "auth.php";

$input = getJsonInput();
$id_tarefa = intval($input["id_tarefa"] ?? 0);
$email_destino = trim($input["email_destino"] ?? "");

if ($id_tarefa <= 0 || $email_destino === "") {
    response(false, "Dados inválidos.");
}

$id_usuario = $_SESSION["user_id"];

// verifica se tarefa é do usuário logado
$stmt = $pdo->prepare("SELECT id FROM tarefas WHERE id = ? AND id_usuario = ?");
$stmt->execute([$id_tarefa, $id_usuario]);
$task = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$task) {
    response(false, "Tarefa não encontrada ou não pertence ao usuário.");
}

// pega usuário destino
$stmt2 = $pdo->prepare("SELECT id FROM usuarios WHERE email = ?");
$stmt2->execute([$email_destino]);
$destino = $stmt2->fetch(PDO::FETCH_ASSOC);

if (!$destino) {
    response(false, "Usuário destino não encontrado.");
}

if ($destino["id"] == $id_usuario) {
    response(false, "Você não pode compartilhar com você mesmo.");
}

// insere compartilhamento
try {
    $stmt3 = $pdo->prepare("INSERT INTO tarefas_compartilhadas (id_tarefa, id_usuario_destino) VALUES (?, ?)");
    $stmt3->execute([$id_tarefa, $destino["id"]]);
    response(true, "Tarefa compartilhada com sucesso.");
} catch (Exception $e) {
    response(false, "Essa tarefa já foi compartilhada com esse usuário.");
}
?>
