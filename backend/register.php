<?php
require_once "config.php";
require_once "utils.php";

$input = getJsonInput();

$nome = trim($input["nome"] ?? "");
$email = trim($input["email"] ?? "");
$senha = $input["senha"] ?? "";

if ($nome === "" || $email === "" || $senha === "") {
    response(false, "Preencha todos os campos.");
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    response(false, "E-mail inválido.");
}

$senha_hash = password_hash($senha, PASSWORD_DEFAULT);

try {
    $stmt = $pdo->prepare("INSERT INTO usuarios (nome, email, senha_hash) VALUES (?, ?, ?)");
    $stmt->execute([$nome, $email, $senha_hash]);
    response(true, "Usuário cadastrado com sucesso.");
} catch (Exception $e) {
    response(false, "Erro ao cadastrar usuário. Talvez o e-mail já exista.");
}
?>
