<?php
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if (isset($_POST['tipo_usuario']) && !empty($_POST['tipo_usuario'])) {
        $tipo_usuario = $_POST['tipo_usuario'];

        $_SESSION['tipo_usuario'] = $tipo_usuario;

        if ($tipo_usuario === 'Personal') {
            header('Location: ../personal/personal_login.php'); 
            exit();
        } else {
            header('Location: ../aluno/aluno_login.php'); 
            exit();
        }
    } else {
        $_SESSION['erro'] = 'Por favor, selecione uma opção.';
        header('Location: escolha.php');
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/escolha.css" />
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png">
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Bem vindo(a)</title>
    <title>Escolha</title>
</head>
<body>
    <main id="container">
        <div id="choice-screen">
            <form id="login_form" method="POST" action="escolha.php">
                <div id="form_header">
                    <h1>Você é...?</h1>
                </div>

                <div id="inputs">
                    <div id="input-box">
                        <div class="input-field">
                            <input type="radio" id="personal" name="tipo_usuario" value="Personal">
                            <label for="personal">Personal</label><br>
                            <input type="radio" id="aluno" name="tipo_usuario" value="Aluno">
                            <label for="aluno">Aluno</label><br>
                        </div>
                    </div>
                </div>

                <button type="submit" id="login_button">Comece já</button>
            </form>
        </div>
    </main>

    <script src="../../assets/js/escolha.js"></script>

    <?php
    if (isset($_SESSION['erro'])) {
        echo "<script>alert('" . $_SESSION['erro'] . "');</script>";
        unset($_SESSION['erro']);
    }
    ?>
</body>
</html>
