<?php
session_start();
include '../db/conexao.php';

if (!isset($_GET['id_treino']) || empty($_GET['id_treino'])) {
    http_response_code(400);
    echo "ID do treino não informado.";
    exit;
}

$id_treino = (int) $_GET['id_treino'];
$conclu = "s";

$queryTreino = "UPDATE treino SET conclusao = ? WHERE numero_treino = ?";
$stmtTreino = $conn->prepare($queryTreino);

if ($stmtTreino) {
    $stmtTreino->bind_param("si", $conclu, $id_treino);
    if ($stmtTreino->execute()) {
        http_response_code(200);
        echo "<script>alert('Treino concluído com sucesso!'); window.history.back();</script>";
    } else {
        http_response_code(500);
        echo "Erro ao atualizar a conclusão do treino.";
    }
    $stmtTreino->close();
} else {
    http_response_code(500);
    echo "Erro ao preparar a consulta.";
}

$conn->close();