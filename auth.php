<?php
// backend/auth.php
require_once "utils.php";

if (!isset($_SESSION["user_id"])) {
    http_response_code(401);
    response(false, "Não autorizado. Faça login.");
}
?>
