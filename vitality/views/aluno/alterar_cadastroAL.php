<?php
session_start();
include('../../db/conexao.php'); 

$id_aluno = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campo = $_POST['campoAlteracao'];
    $novoValor = $_POST[$campo] ?? null;

    if ($novoValor) {
        if ($campo === 'nome_aluno') {
            $sql = "UPDATE aluno SET nome_aluno = ? WHERE id_aluno = ?";
        } elseif ($campo === 'email') {
            $email = $_POST['email'];
            $sqlVerificarEmail = "SELECT * FROM aluno WHERE email = ? AND id_aluno != ?";
            $stmtVerificarEmail = $conn->prepare($sqlVerificarEmail);
            $stmtVerificarEmail->bind_param("si", $email, $id_aluno);
            $stmtVerificarEmail->execute();
            $resultado = $stmtVerificarEmail->get_result();

            if ($resultado->num_rows > 0) {
                echo "<p style='color: red;'>O email já está em uso. Por favor, escolha outro.</p>";
                exit();
            }

            $sql = "UPDATE aluno SET email = ? WHERE id_aluno = ?";
        } else {
            echo "<p style='color: red;'>Campo inválido.</p>";
            exit();
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $novoValor, $id_aluno);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Alteração realizada com sucesso!</p>";
        } else {
            echo "<p style='color: red;'>Erro ao atualizar o cadastro. Tente novamente.</p>";
        }

        $stmt->close();
    } else {
        echo "<p style='color: red;'>Por favor, preencha o campo selecionado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Cadastro - Aluno</title>
    <link rel="stylesheet" href="../../assets/css/alterar_cadsAL.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <script src="../../assets/js/alterar_cadsAL.js"></script>
</head>
<body>
    <a href="perfil_aluno.php" class="back-icon">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div class="card">
        <h2>Alterar Cadastro</h2>
        <form id="formAlterarCadastro" method="POST" action="">
            <label for="campoAlteracao">Selecione o campo para alterar:</label>
            <select id="campoAlteracao" name="campoAlteracao" onchange="mostrarInput()" required>
                <option value="">Selecione</option>
                <option value="nome_aluno">Nome</option>
                <option value="email">Email</option>
            </select>

            <div id="inputNome" style="display: none;">
                <label for="nome_aluno">Novo Nome:</label>
                <input type="text" id="nome_aluno" name="nome_aluno" placeholder="Digite o novo nome">
            </div>

            <div id="inputEmail" style="display: none;">
                <label for="email">Novo Email:</label>
                <input type="email" id="email" name="email" placeholder="Digite o novo email">
            </div>

            <button type="submit">Alterar</button>
        </form>
    </div>
</body>
</html>
