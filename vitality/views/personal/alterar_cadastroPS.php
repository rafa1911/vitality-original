<?php
session_start();
include('../../db/conexao.php'); 

$id_personal = $_SESSION['usuario_id'];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $campo = $_POST['campoAlteracao'];
    $novoValor = $_POST[$campo] ?? null;

    if ($campo === 'excluir_conta') {
        $sqlExcluir = "DELETE FROM personal WHERE id_personal = ?";
        $stmtExcluir = $conn->prepare($sqlExcluir);
        $stmtExcluir->bind_param("i", $id_personal);

        if ($stmtExcluir->execute()) {
            echo "<p style='color: green;'>Conta excluída com sucesso!</p>";
            session_destroy();
            header("Location: ../../index.html");
            exit();
        } else {
            echo "<p style='color: red;'>Erro ao excluir a conta. Por favor, tente novamente.</p>";
        }
        $stmtExcluir->close();
    } elseif ($novoValor) {
        if ($campo === 'email') {
            $sqlVerificarEmail = "SELECT id_personal FROM personal WHERE email = ? AND id_personal != ?";
            $stmtVerificar = $conn->prepare($sqlVerificarEmail);
            $stmtVerificar->bind_param("si", $novoValor, $id_personal);
            $stmtVerificar->execute();
            $stmtVerificar->store_result();

            if ($stmtVerificar->num_rows > 0) {
                echo "<p style='color: red;'>O e-mail informado já está em uso. Por favor, escolha outro e-mail.</p>";
                $stmtVerificar->close();
                exit();
            }
            $stmtVerificar->close();

            $sql = "UPDATE personal SET email = ? WHERE id_personal = ?";
        } elseif ($campo === 'nome_personal') {
            $sql = "UPDATE personal SET nome_personal = ? WHERE id_personal = ?";
        } else {
            echo "<p style='color: red;'>Campo inválido selecionado.</p>";
            exit();
        }

        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $novoValor, $id_personal);

        if ($stmt->execute()) {
            echo "<p style='color: green;'>Alteração realizada com sucesso!</p>";
        } else {
            echo "<p style='color: red;'>Erro ao atualizar os dados. Por favor, tente novamente.</p>";
        }
        $stmt->close();
    } else {
        echo "<p style='color: red;'>Por favor, preencha o campo solicitado.</p>";
    }
}
?>

<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Alterar Cadastro - Personal</title>
    <link rel="stylesheet" href="../../assets/css/alterar_cadsPS.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <script src="../../assets/js/alterar_cadsPS.js"></script>
</head>
<body>
    <a href="perfil_personal.php" class="back-icon">
        <i class="fa-solid fa-arrow-left"></i>
    </a>
    <div class="card">
        <h2>Alterar Cadastro</h2>
        <form id="formAlterarCadastro" method="POST" action="">
            <label for="campoAlteracao">Selecione o campo para alterar:</label>
            <select id="campoAlteracao" name="campoAlteracao" onchange="mostrarInput()" required>
                <option value="">Selecione</option>
                <option value="nome_personal">Nome</option>
                <option value="email">Email</option>
                <option value="excluir_conta">Excluir Conta</option>
            </select>

            <div id="inputNome" style="display: none;">
                <label for="nome_personal">Novo Nome:</label>
                <input type="text" id="nome_personal" name="nome_personal" placeholder="Digite o novo nome">
            </div>

            <div id="inputEmail" style="display: none;">
                <label for="email">Novo Email:</label>
                <input type="email" id="email" name="email" placeholder="Digite o novo email">
            </div>

            <button type="submit">Alterar</button>
        </form>
        <div id="mensagens"></div>
    </div>
</body>

<script>
    function mostrarInput() {
    const campo = document.getElementById("campoAlteracao").value;
    document.getElementById("inputNome").style.display = campo === "nome_personal" ? "block" : "none";
    document.getElementById("inputEmail").style.display = campo === "email" ? "block" : "none";
}
</script>
</html>
