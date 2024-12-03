<?php
session_start();
include '../db/conexao.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_SESSION['id_aluno']) && isset($_POST['tipo_documento'])) {
        $id_aluno = $_SESSION['id_aluno'];
        $id_personal = $_SESSION['usuario_id']; 
        $tipo_documento = $_POST['tipo_documento'];

        $query_insert = "INSERT INTO solicitacoes (fk_aluno_id_aluno, fk_personal_id_personal, tipo_documento, status, created_at) 
                         VALUES (?, ?, ?, 'Pendente', NOW())";
        $stmt_insert = $conn->prepare($query_insert);

        if ($stmt_insert) {
            $stmt_insert->bind_param("iis", $id_aluno, $id_personal, $tipo_documento);
            if ($stmt_insert->execute()) {
                echo "<p>Solicitação enviada com sucesso!</p>";
            } else {
                echo "<p>Erro ao enviar a solicitação: " . $stmt_insert->error . "</p>";
            }
            $stmt_insert->close();
        } else {
            echo "<p>Erro na preparação da consulta: " . $conn->error . "</p>";
        }
    } else {
        echo "<p>Por favor, selecione um tipo de documento.</p>";
    }
}