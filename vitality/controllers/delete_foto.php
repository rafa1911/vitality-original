<?php
session_start();


$host = "localhost"; 			
$user = "root"; 
$pass = ""; 
$banco = "vitality";

$conn = new mysqli($host, $user, $pass, $banco);

if ($conn->connect_error) {
    die("Conexão falhou: " . $conn->connect_error);
}

$tipo_usuario = $_SESSION['tipo_usuario'];
$id_usuario = $_SESSION['usuario_id'];

function obter_foto_padrao($tipo_usuario) {
    return "../../uploads/default/default_" . $tipo_usuario . ".png"; 
}

if ($tipo_usuario === 'aluno') {
    $sql_select = "SELECT foto_perfil_aluno FROM aluno WHERE id_aluno = ?";
} else {
    $sql_select = "SELECT foto_perfil_personal FROM personal WHERE id_personal = ?";
}

$stmt_select = $conn->prepare($sql_select);
$stmt_select->bind_param("i", $id_usuario);
$stmt_select->execute();
$stmt_select->bind_result($foto_atual);
$stmt_select->fetch();
$stmt_select->close();

$foto_padrao = obter_foto_padrao($tipo_usuario);

if ($tipo_usuario === 'aluno') {
    $sql_update = "UPDATE aluno SET foto_perfil_aluno = ? WHERE id_aluno = ?";
} else {
    $sql_update = "UPDATE personal SET foto_perfil_personal = ? WHERE id_personal = ?";
}

$stmt_update = $conn->prepare($sql_update);
$stmt_update->bind_param("si", $foto_padrao, $id_usuario);
$stmt_update->execute();
$stmt_update->close();

if ($foto_atual && $foto_atual !== $foto_padrao && file_exists($foto_atual)) {
    unlink($foto_atual);
}

if ($tipo_usuario === 'aluno') {
    header("Location: ../views/aluno/perfil_aluno.php");
} else {
    header("Location: ../views/personal/perfil_personal.php");
}
exit();
?>
