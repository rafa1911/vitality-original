<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include '../../db/conexao.php';
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.11.2/css/all.css">
    <script src="https://kit.fontawesome.com/64d58efce2.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="../../assets/css/aluno_login.css" />
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <link rel="icon" href="img/favicon.png" type="image/png"> 
    <link rel="icon" href="favicon.ico" type="image/x-icon">
    <title>Vitality - Login</title>
</head>
<body>
    <div class="container">
        <div class="forms-container">
            <div class="signin-signup">
                <form class="sign-in-form" method="POST" action="loginAL.php">
                    <h2 class="title">Entrar</h2>
                    <div class="input-field">
                        <i class="fas fa-user"></i>
                        <input type="text" placeholder="E-mail" name="email" required />
                    </div>
                    <div class="input-field">
                        <i class="fas fa-lock"></i>
                        <input type="password" placeholder="Senha" name="senha" required />
                    </div>
                    <input type="submit" value="Login" class="btn solid" />
                    <div class="forgot-password">
                        <a href="../shared/senha.php">Esqueci minha senha</a>
                    </div>
                </form>
            </div>
        </div>
        <div class="panels-container">
            <div class="panel left-panel">
                <div class="back-button">
                    <button class="btn transparent" onclick="window.location.href='../shared/escolha.php'">
                        <i class="fas fa-arrow-left"></i> Voltar
                    </button>
                </div>
                <div class="content">
                    <h3>Que bom ter você aluno(a)</h3>
                    <p>Seja bem-vindo ao Vitality!</p>
                </div>
                <img src="img/" class="image" alt="" />
            </div>
        </div>
    </div>
    <script src="../../assets/js/aluno.js"></script>
</body>
</html>
