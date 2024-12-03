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
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title>Sair - Vitality</title>
    <link rel="stylesheet" href="../../assets/css/sair.css">
</head>
<body>
    <div class="overlay" id="overlay">
        <div class="logout-card">
            <h2>Deseja sair da sua conta?</h2>
            <p>Você está prestes a encerrar sua sessão.</p>
            <div class="button-group">
                <button class="btn-confirm" id="confirm-logout" onclick="window.location.href='../../index.html'">Sim, sair</button>
                <button class="btn-cancel" id="cancel-logout">Cancelar</button>
            </div>
        </div>
    </div>

    <script src="../../assets/js/sair.js"></script>
    <script>
        document.getElementById('cancel-logout').addEventListener('click', function() {
            window.location.href = "<?= $redirecionamento ?>";
        });
    </script>
</body>
</html>
