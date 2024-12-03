<?php if (session_status() === PHP_SESSION_NONE) {
    session_start();
}?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../assets/css/cadastro_aluno.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <link rel="icon" href="../../assets/img/favicon.svg" type="image/svg+xml">
    <title>Cadastro de Aluno</title>
</head>
<body>
    <div class="container">
        <div class="form-header">
            <h1>Cadastro de Aluno</h1>
            <h3>Envie as informações do seu aluno para o cadastrar</h3>
        </div>
        <form id="cadastro-form" method="POST" action="../../controllers/cadastro_aluno.php">
            <div class="input-box">
                <label for="nome">Nome Completo</label>
                <input type="text" id="nome" name="nome" required>
            </div>
            <div class="input-box">
                <label for="email">E-mail</label>
                <input type="email" id="email" name="email" required>
            </div>
            <div class="input-box">
                <label for="senha">Senha</label>
                <input type="password" id="senha" name="senha" required>
            </div>
            <div class="btn-container">
                <a href="javascript:window.history.back();" class="btn">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
                <button type="submit" class="btn">
                    <i class="fas fa-user-plus"></i> Cadastrar
                </button>
            </div>
        </form>
    </div>
</body>
</html>
