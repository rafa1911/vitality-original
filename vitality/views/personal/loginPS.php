<?php
session_start();
include '../../db/conexao.php';

$email = $_POST['email'];
$senha = $_POST['senha'];

$sql_personal = "SELECT * FROM personal WHERE email = ?";
$stmt_personal = $conn->prepare($sql_personal);
$stmt_personal->bind_param("s", $email);
$stmt_personal->execute();
$result_personal = $stmt_personal->get_result();

if ($result_personal->num_rows > 0) {
    $row = $result_personal->fetch_assoc();
    if (password_verify($senha, $row['senha'])) {
        $_SESSION['usuario_id'] = $row['id_personal'];
        header("Location: perfil_personal.php?id=" . $row['id_personal']);
        exit();
    } else {
        $_SESSION['error_message'] = "Senha incorreta para personal.";
        header("Location: personal_login.php");
        exit();
    }
}
$_SESSION['error_message'] = "Usuário não encontrado.";
echo "<script>alert('Erro no login!'); window.history.back();</script>";
header("Location: ../../index.html"); //FAZER MENSAGEM DE ERRO!!  
exit();
