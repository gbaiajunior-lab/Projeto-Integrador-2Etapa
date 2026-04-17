<?php
// backend/utils.php
header("Content-Type: application/json; charset=UTF-8");

function getJsonInput() {
    $data = json_decode(file_get_contents("php://input"), true);
    return $data ? $data : [];
}

function response($success, $message, $data = null) {
    echo json_encode([
        "success" => $success,
        "message" => $message,
        "data" => $data
    ]);
    exit;
}

session_start();
?>
