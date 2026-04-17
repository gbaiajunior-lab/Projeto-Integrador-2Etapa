<?php
require_once "config.php";
require_once "utils.php";
require_once "auth.php";

$id_usuario = $_SESSION["user_id"];

// tarefas do usuário
$stmt = $pdo->prepare("
    SELECT t.* 
    FROM tarefas t
    WHERE t.id_usuario = ?
    ORDER BY t.criado_em DESC
");
$stmt->execute([$id_usuario]);
$minhas = $stmt->fetchAll(PDO::FETCH_ASSOC);

// tarefas compartilhadas comigo
$stmt2 = $pdo->prepare("
    SELECT t.*, u.nome AS dono_nome, u.email AS dono_email
    FROM tarefas_compartilhadas tc
    INNER JOIN tarefas t ON tc.id_tarefa = t.id
    INNER JOIN usuarios u ON t.id_usuario = u.id
    WHERE tc.id_usuario_destino = ?
    ORDER BY t.criado_em DESC
");
$stmt2->execute([$id_usuario]);
$compartilhadas = $stmt2->fetchAll(PDO::FETCH_ASSOC);

response(true, "Tarefas listadas.", [
    "minhas" => $minhas,
    "compartilhadas" => $compartilhadas
]);
?>
