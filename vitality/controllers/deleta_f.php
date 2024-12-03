<?php
session_start();
include '../db/conexao.php';

$id_modelo = intval($_POST['id_modelo']);

$conn->begin_transaction();

$query_perguntas = "DELETE FROM perguntas_modelo WHERE fk_modelo_id_modelo = ?";
$stmt_perguntas = $conn->prepare($query_perguntas);
$stmt_perguntas->bind_param("i", $id_modelo);
$stmt_perguntas->execute();
$stmt_perguntas->close();

$query_modelo = "DELETE FROM modelos_ficha WHERE id_modelo = ?";
$stmt_modelo = $conn->prepare($query_modelo);
$stmt_modelo->bind_param("i", $id_modelo);
$stmt_modelo->execute();
$stmt_modelo->close();

$conn->commit();

echo "Ficha apagada com sucesso!";
header('Location: modelos.php');
exit;
