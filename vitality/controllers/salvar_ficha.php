<?php
include_once '../db/conexao.php';

$modelo = $_GET['id'];
$id_alun = $_SESSION['id_aluno'];
$id_pers = $_SESSION['usuario_id'];
$now = date("Y-n-j"); 
$r = "n";

$sql = "INSERT INTO ficha_anamnese 
            (modelo, fk_personal_id_personal, fk_aluno_id_aluno, data_criacao, respondido)
        VALUES 
            (?, ?, ?, ?, ?)";

$stmt = $conn->prepare($sql);
$stmt->bind_param('iisss',$modelo, $id_pers, $id_alun, $now, $r);

if ($stmt->execute()) {
    echo "<script>alert('Ficha de anamnese salva com sucesso!'); window.history.back();</script>";
} else {
    echo "Erro ao salvar a ficha: " . $stmt->error;
}

$stmt->close();
$conn->close();
