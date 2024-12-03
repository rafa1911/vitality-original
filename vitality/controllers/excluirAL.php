<?php
include '../db/conexao.php';

$id = $_GET['id']; 

$sql = "DELETE FROM aluno WHERE id_aluno = ?";
$stmt = mysqli_prepare($conn, $sql);
mysqli_stmt_bind_param($stmt, "i", $id);
mysqli_stmt_execute($stmt);
mysqli_stmt_close($stmt);

mysqli_close($conn);

var_dump($id);
header("Location: ../views/personal/perfil_personal.php");
exit();