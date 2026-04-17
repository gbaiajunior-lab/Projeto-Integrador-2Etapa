<?php
require_once "config.php";
require_once "utils.php";

$input = getJsonInput();

$email = trim($input["email"] ?? "");
$senha = $input["senha"] ?? "";

if ($email === "" || $senha === "") {
    response(false, "Informe e-mail e senha.");
}

$stmt = $pdo->prepare("SELECT id, nome, email, senha_hash FROM usuarios WHERE email = ?");
$stmt->execute([$email]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    response(false, "Usuário não encontrado.");
}

if (!password_verify($senha, $user["senha_hash"])) {
    response(false, "Senha incorreta.");
}

// sessão
$_SESSION["user_id"] = $user["id"];
$_SESSION["user_nome"] = $user["nome"];
$_SESSION["user_email"] = $user["email"];

response(true, "Login realizado com sucesso.", [
    "id" => $user["id"],
    "nome" => $user["nome"],
    "email" => $user["email"]
]);
?>
