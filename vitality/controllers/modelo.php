<?php
session_start(); 

if (!isset($_SESSION['usuario_id'])) {
    echo "<script>alert('Erro: Você precisa estar logado para acessar esta página.');</script>";
    echo "<script>window.location.href='login.php';</script>";
    exit();
}

$id_personal = $_SESSION['usuario_id'];

include '../db/conexao.php'; 

$query = "SELECT COUNT(*) FROM personal WHERE id_personal = ?";
$stmt = $conn->prepare($query);
$stmt->bind_param("i", $id_personal);
$stmt->execute();
$stmt->bind_result($count);
$stmt->fetch();
$stmt->close();

if ($count == 0) {
    echo "<script>alert('Erro: ID do personal não encontrado na tabela.');</script>";
    exit();
}

?>


<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ficha Anamnese</title>
    <link rel="stylesheet" href="../assets/css/modelo.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="icon" href="../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png"> 
    <link rel="icon" href="favicon.ico" type="image/x-icon">
</head>
<body>
    <div class="container">
        <h1>Ficha Anamnese</h1>
        <a href="../views/personal/perfilAL.php" class="back-button">
            <i class="fas fa-arrow-left"></i> Voltar
        </a>
        <div class="button-container">
            <a href="criar.html" class="button">
            <i class="fas fa-file-medical-alt"></i>  Criar Modelo
            </a>
            <a href="selecione.php" class="button">
            <i class="fas fa-clipboard-check"></i>  Selecionar Modelo
            </a>
            <a href="fichas_de_alunos.php" class="button">
                <i class="fas fa-user-check"></i> Fichas do Aluno
            </a>
        </div>
    </div>
</body>
</html>
