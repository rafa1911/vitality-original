<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/senha.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title>Redefinir Senha</title>

    <script type="text/javascript" src="https://cdn.jsdelivr.net/npm/@emailjs/browser@4/dist/email.min.js"></script>
    <script type="text/javascript">
        (function(){
            emailjs.init("f9n8c2JclEd8-dRfB"); 
        })();
    </script>
</head>

<?php 
session_start();
$tipoUsuario = $_SESSION['tipo_usuario'];
$redirecionamento = $tipoUsuario === 'Personal' ? '../views/personal/perfil_personal.php' : '../views/aluno/perfil_aluno.php';

?>
<body>
    <div class="container">
        <div class="steps">
            <div class="step active">1</div>
            <div class="step">2</div>
            <div class="step">3</div>
            <div class="step">4</div>
        </div>

        <form id="step-1" class="form-step active" method="POST">
            <div class="form-header">
                <h1>Redefinir Senha</h1>
            </div>
            <div class="input-box">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
                <div id="email-warning" style="color: red; display: none;">
                    Por favor, insira um e-mail válido.
                </div>
            </div>
            <button type="button" class="btn next-btn" id="send-email-btn">Próximo</button>
        </form>

        <form id="step-2" class="form-step" method="POST">
            <h2>Insira o código</h2>
            <div class="input-box">
                <label for="cod">Código</label>
                <input type="text" id="cod" name="cod" required>
                <div id="cod-warning" style="color: red; display: none;">
                    Código inválido! Tente novamente.
                </div>
            </div>
            <button type="button" class="btn prev-btn">Voltar</button>
            <button type="button" class="btn next-btn">Próximo</button>
        </form>

        <form id="step-3" class="form-step">
            <h2>Defina sua nova senha</h2>
            <div class="input-box">
                <label for="novasenha">Nova Senha</label>
                <input type="password" id="novasenha" name="novasenha" required>
                <div id="novasenha-warning" style="color: red; display: none;">
                    A senha deve ter exatamente 6 dígitos.
                </div>
            </div>
            <div class="input-box">
                <label for="cnsenha">Confirme a nova senha</label>
                <input type="password" id="cnsenha" name="cnsenha" required>
                <div id="cnsenha-warning" style="color: red; display: none;">
                    As senhas não coincidem.
                </div>
            </div>
            <button type="button" class="btn prev-btn">Voltar</button>
            <button type="button" class="btn next-btn" id="validate-password-btn">Continuar</button>
        </form>

        <div id="step-4" class="form-step">
            <h2>Sucesso!</h2>
            <p>Sua senha foi redefinida com sucesso.</p>
            <button id="close-button" class="btn next-btn">Continuar</button>
        </div>
    </div>

    <script src="../../assets/js/senha.js"></script>
    <script>
        document.getElementById('close-button').addEventListener('click', function() {
            window.location.href = "<?= $redirecionamento ?>";
        });
    </script>
</body>
</html>
