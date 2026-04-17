<?php
require_once "utils.php";

session_destroy();
response(true, "Logout realizado.");
?>
