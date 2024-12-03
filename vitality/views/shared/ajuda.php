<?php
session_start();


$tipoUsuario = $_SESSION['tipo_usuario'];
$redirecionamento = $tipoUsuario === 'Personal' ? '../personal/perfil_personal.php' : '../aluno/perfil_aluno.php';
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/ajuda.css" />
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title>Ajuda - Vitality</title>
</head>
<body>

    <div class="overlay hidden" id="help-overlay">
        <div class="help-box">
            <div class="form_header">
                <h1>Precisando de ajuda?</h1>
                <p>Entre em contato:</p>
                <p><a href="mailto:tccvitality@gmail.com">tccvitality@gmail.com</a></p>
            </div>
            <button id="close-button">Fechar</button>
        </div>
    </div>

    <script>
        document.getElementById('close-button').addEventListener('click', function() {
            window.location.href = "<?= $redirecionamento ?>";
        });
    </script>
</body>
</html>
