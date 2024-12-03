<?php 
session_start();
include("../db/conexao.php");

$id_aluno = $_GET['id'] ?? $_SESSION['id_aluno'];
$id_personal = $_SESSION['usuario_id'];
$_SESSION['id_aluno'] = $id_aluno;

$nomeTreino = $_POST['nome_treino'];
$membro = $_POST['membro'];
$aparelhos = $_POST['aparelhos'];
$series = $_POST['series'];
$repeticoes = $_POST['repeticoes'];
$descansos = $_POST['descansos'];
$conclu = "n";

$id_treino = intval(microtime(true) * 1000) + $id_personal;

$queryTreino = "INSERT INTO treino (numero_treino, tipo, fk_personal_id_personal, fk_aluno_id_aluno, conclusao) VALUES (?, ?, ?, ?, ?)";
$stmtTreino = $conn->prepare($queryTreino);
$stmtTreino->bind_param("isiis", $id_treino, $nomeTreino, $id_personal, $id_aluno, $conclu);

if ($stmtTreino->execute()) {
    $queryAparelho = "INSERT INTO treino_aparelho (numero_treino, aparelho, series, repeticao, descanso) VALUES (?, ?, ?, ?, ?)";
    $stmtAparelho = $conn->prepare($queryAparelho);

    foreach ($aparelhos as $index => $aparelho) {
        $serie = $series[$index] ?? 0;
        $repeticao = $repeticoes[$index] ?? 0;
        $descanso = $descansos[$index] ?? '0s';

        $stmtAparelho->bind_param("isiii", $id_treino, $aparelho, $serie, $repeticao, $descanso);
        $stmtAparelho->execute();
    }

    $stmtAparelho->close();
    echo "<script>alert('Treino montado com sucesso!'); window.location.href = '../views/personal/perfilAL.php?id=$id_aluno';</script>";
} else {
    echo "<script>alert('Erro ao salvar o treino.');</script>";
}

$stmtTreino->close();
$conn->close();
?>
