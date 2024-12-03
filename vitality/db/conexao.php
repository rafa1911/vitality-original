<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

$host = "localhost";
$user = "root";
$pass = "";
$banco = "vitality";

$conn = @mysqli_connect($host, $user, $pass, $banco)
	or die("Problemas com a conexão do Banco de Dados");
mysqli_set_charset($conn, "utf8");